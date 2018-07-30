<?php

namespace VKMapperBundle\DependencyInjection\Compiler;

use DataMapper\MapperInterface;
use DataMapper\NamingStrategy\SnakeCaseNamingStrategy;
use DataMapper\NamingStrategy\UnderscoreNamingStrategy;
use DataMapper\Type\TypeDict;
use VKMapperBundle\Annotation\Exception\InvalidTypeException;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedInterface;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\Map;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\NamingStrategyInterface;
use VKMapperBundle\StrategyAdapter\StaticClosureStrategyAdapter;
use VKMapperBundle\StrategyAdapter\ServiceClosureStrategyAdapter;
use VKMapperBundle\Annotation\MappingMetaReader;
use VKMapperBundle\Annotation\AnnotationReaderInterface;
use VKMapperBundle\Annotation\MappingMeta\Strategy as MetaStrategy;
use VKMapperBundle\Annotation\MappingMeta\Strategy\StrategyInterface as MetaStrategyInterface;

use DataMapper\Strategy\CollectionStrategy;
use DataMapper\Strategy;
use DataMapper\Hydrator\ArrayCollectionHydrator;
use DataMapper\MappingRegistry;
use DataMapper\Type\TypeResolver;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class MappingCompilePass
 */
class MappingCompilePass implements CompilerPassInterface
{
    private const DTO_MAPPER_TAG = 'dto_mapper.annotated';
    private const DTO_MAPPER_HYDRATOR_TAG = 'dto_mapper.hydrator';

    /**
     * @throws \Exception
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        $this
            ->registerHydrators($container)
            ->registerMapping($container);
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return MappingCompilePass
     */
    private function registerHydrators(ContainerBuilder $container): self
    {
        $hydrationRegistry = $container->getDefinition(MappingRegistry\HydratorRegistry::class);
        $baseHydrationTypes = TypeResolver::hydrationSupportedTypeSequence();

        foreach ($baseHydrationTypes as $type => $hydratorClass) {
            $hydrationRegistry->addMethodCall('registerHydrator', [new Reference($hydratorClass), $type]);
        }

        foreach ($container->findTaggedServiceIds(self::DTO_MAPPER_HYDRATOR_TAG) as $id => $tag) {
            if (!isset($tag['type'])) {
                throw new InvalidTypeException("You must register hydrator type for: $id");
            }

            $hydrationRegistry->addMethodCall('registerHydrator', [new Reference($id), $tag['type']]);
        }

        return $this;
    }

    /**
     * @throws \Exception
     *
     * @param ContainerBuilder $container
     *
     * @return MappingCompilePass
     */
    private function registerMapping(ContainerBuilder $container): self
    {
        $destinationRegistry = $container->getDefinition(MappingRegistry\DestinationRegistry::class);

        /** @var MappingMetaReader $metaReader */
        foreach ($this->loadMapping($container) as $id => $metaReader) {
            if ($metaReader->skip()) {
                continue;
            }

            if (true === $metaReader->isDestination()) {
                $destinationRegistry->addMethodCall('registerDestinationClass', [$id]);
            }

            if (true === $metaReader->isSource()) {
                $destinationRegistry->addMethodCall('registerDestinationClass', [$id]);
            }

            $this
                ->registerNaming($container, $metaReader, $id)
                ->registerRelations($container, $metaReader, $id)
                ->registerStrategies($container, $metaReader, $id);
        }

        return $this;
    }

    /**
     * @param ContainerBuilder  $container
     * @param MappingMetaReader $metaReader
     * @param string            $id
     *
     * @return MappingCompilePass
     */
    private function registerStrategies(
        ContainerBuilder $container,
        MappingMetaReader $metaReader,
        string $id
    ): self {
        $strategyRegistry = $container->getDefinition(MappingRegistry\StrategyRegistry::class);
        /** @var MetaStrategy\StrategyInterface $strategy */
        foreach ($metaReader->getPropertiesStrategies() as $propertyName => $strategy) {
            if ($strategy->getSource()) {
                $strategyKey = TypeResolver::getStrategyType($strategy->getSource(), $id);
                $strategyRegistry->addMethodCall(
                    'registerPropertyStrategy',
                    [
                        $strategyKey,
                        $propertyName,
                        $this->createStrategyDefinition($container, $strategy),
                    ]
                );
            } else {
                $strategyKey = TypeResolver::getStrategyType($id, TypeDict::ALL_TYPE);
                $strategyRegistry->addMethodCall(
                    'registerPropertyStrategy',
                    [
                        $strategyKey,
                        $propertyName,
                        $this->createStrategyDefinition($container, $strategy),
                    ]
                );
            }
        }

        return $this;
    }


    /**
     * @param ContainerBuilder  $container
     * @param MappingMetaReader $metaReader
     * @param string            $id
     *
     * @return MappingCompilePass
     */
    private function registerRelations(
        ContainerBuilder $container,
        MappingMetaReader $metaReader,
        string $id
    ): self {
        $strategyRegistry = $container->getDefinition(MappingRegistry\StrategyRegistry::class);

        /** @var EmbeddedInterface $embedded */
        foreach ($metaReader->getRelationsProperties() as $propertyName => $embedded) {
            $strategy = new Definition(
                Strategy\CollectionStrategy::class,
                [
                    new Reference(MapperInterface::class),
                    $embedded->getTarget(),
                    $embedded->isMulti(),
                ]
            );

            if ($metaReader->isSource()) {
                $strategyKey = TypeResolver::getStrategyType($id, TypeDict::ALL_TYPE);
                $strategyRegistry->addMethodCall(
                    'registerPropertyStrategy',
                    [
                        $strategyKey,
                        $propertyName,
                        $strategy,
                    ]
                );
            }

            if ($metaReader->isDestination()) {
                $strategyKey = TypeResolver::getStrategyType(TypeDict::ARRAY_TYPE, $id);
                $strategyRegistry->addMethodCall(
                    'registerPropertyStrategy',
                    [
                        $strategyKey,
                        $propertyName,
                        $strategy,
                    ]
                );

                $strategyKey = TypeResolver::getStrategyType(TypeDict::ALL_TYPE, $id);
                $strategyRegistry->addMethodCall(
                    'registerPropertyStrategy',
                    [
                        $strategyKey,
                        $propertyName,
                        $strategy,
                    ]
                );
            }
        }

        return $this;
    }

    /**
     * @param ContainerBuilder  $container
     * @param MappingMetaReader $reader
     * @param string            $id
     *
     * @return MappingCompilePass
     */
    private function registerNaming(
        ContainerBuilder $container,
        MappingMetaReader $reader,
        string $id
    ): self {
        $namingStrategyRegistry = $container->getDefinition(MappingRegistry\NamingStrategyRegistry::class);

        $hasDefaultSource = false;
        foreach ($reader->getSourceNamingStrategies() as $namingStrategy) {
            $hasDefaultSource = true;
            $definition = $this->createNamingStrategy($namingStrategy);
            $namingStrategyRegistry->addMethodCall(
                'registerNamingStrategy',
                [
                    TypeResolver::getStrategyType($id, TypeDict::ALL_TYPE),
                    $definition,
                ]
            );
        }

        if (false === $hasDefaultSource) {
            $namingStrategyRegistry->addMethodCall(
                'registerNamingStrategy',
                [
                    TypeResolver::getStrategyType($id, TypeDict::ARRAY_TYPE),
                    new Definition(UnderscoreNamingStrategy::class),
                ]
            );
        }

        $hasDefaultDestination = false;
        /** @var NamingStrategyInterface $namingStrategy */
        foreach ($reader->getDestinationNamingStrategies() as $namingStrategy) {
            $hasDefaultDestination = true;
            $definition = $this->createNamingStrategy($namingStrategy);
            $key = TypeResolver::getStrategyType(TypeDict::ALL_TYPE, $id);
            if ($namingStrategy->getSource()) {
                $key = TypeResolver::getStrategyType($namingStrategy->getSource(), $id);
            }

            $namingStrategyRegistry->addMethodCall(
                'registerNamingStrategy',
                [
                    $key,
                    $definition,
                ]
            );
        }

        if (false === $hasDefaultDestination) {
            $namingStrategyRegistry->addMethodCall(
                'registerNamingStrategy',
                [
                    TypeResolver::getStrategyType(TypeDict::ARRAY_TYPE, $id),
                    new Definition(SnakeCaseNamingStrategy::class),
                ]
            );
        }

        return $this;
    }

    /**
     * @param ContainerBuilder      $container
     * @param MetaStrategyInterface $strategy
     *
     * @return Definition
     */
    private function createStrategyDefinition(ContainerBuilder $container, MetaStrategyInterface $strategy): Definition
    {
        switch (\get_class($strategy)) {
            case MetaStrategy\GetterStrategy::class:
                return (
                new Definition(
                    Strategy\GetterStrategy::class,
                    [
                        $strategy->getMethod()
                    ]
                )
                )->setLazy(true);
            case MetaStrategy\PropertyFormatterStrategy::class:
                return (
                new Definition(
                    Strategy\FormatterStrategy::class,
                    [
                        $strategy->getMethod()
                    ]
                )
                )->setLazy(true);
            case MetaStrategy\XPathStrategy::class:
                return (
                new Definition(
                    Strategy\XPathGetterStrategy::class,
                    [
                        new Reference(ArrayCollectionHydrator::class),
                        $strategy->getXPath(),
                    ]
                )
                )->setLazy(true);
            case MetaStrategy\StaticClosureStrategy::class:
                return (
                new Definition(
                    StaticClosureStrategyAdapter::class,
                    [
                        $strategy->getProvider(),
                        $strategy->getMethod(),
                    ]
                )
                )->setLazy(true);
            case MetaStrategy\ChainStrategy::class:
                $args = [];
                foreach ($strategy->getList() as $singleStrategy) {
                    $args[] = $this->createStrategyDefinition($container, $singleStrategy);
                }

                return (
                new Definition(
                    Strategy\ChainStrategy::class,
                    [$args]
                )
                )->setLazy(true);
            case MetaStrategy\ServiceClosureStrategy::class:
                return (
                new Definition(
                    ServiceClosureStrategyAdapter::class,
                    [
                        new Reference($strategy->getProvider()),
                        $strategy->getMethod(),
                    ]
                )
                )->setLazy(true);
        }
    }

    /**
     * @param NamingStrategyInterface $namingStrategy
     *
     * @return Definition|Reference
     */
    private function createNamingStrategy(NamingStrategyInterface $namingStrategy)
    {
        if ($namingStrategy instanceof NamingStrategy\MapNamingStrategy) {
            $converted = [];
            $extracted = null;

            /** @var Map $map */
            foreach ($namingStrategy->getConvert() as $map) {
                $converted[$map->getFrom()] = $map->getTo();
            }
            foreach ($namingStrategy->getExtract() as $map) {
                $extracted[$map->getFrom()] = $map->getTo();
            }

            return new Definition(
                $namingStrategy->getStrategyClassName(),
                [
                    $converted,
                    $extracted,
                ]
            );
        }

        return new Reference($namingStrategy->getStrategyClassName());
    }

    /**
     * @throws \Exception
     *
     * @param ContainerBuilder $container
     *
     * @return \Generator
     */
    private function loadMapping(ContainerBuilder $container): \Generator
    {
        foreach ($container->findTaggedServiceIds(self::DTO_MAPPER_TAG) as $id => $tag) {
            yield $id => $this->createReaderFor($container, $container->getDefinition($id)->getClass());
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $className
     *
     * @return MappingMetaReader
     * @throws \Exception
     */
    private function createReaderFor(ContainerBuilder $container, string $className): MappingMetaReader
    {
        /** @var AnnotationReaderInterface $reader */
        $reader = $container->get(AnnotationReaderInterface::class);

        return MappingMetaReader::createReader($reader, $className);
    }
}
