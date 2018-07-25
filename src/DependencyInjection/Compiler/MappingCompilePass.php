<?php

namespace VKMapperBundle\DependencyInjection\Compiler;

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
    private const DTO_MAPPER_DESTINATION_TAG = 'dto_mapper.destination';
    private const DTO_MAPPER_SOURCE_TAG = 'dto_mapper.source';
    private const DTO_MAPPER_HYDRATOR_TAG = 'dto_mapper.hydrator';

    /**
     * @throws \Exception
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        try {
            $this
                ->registerHydrators($container)
                ->registerMapping($container);
        } catch (\Exception $e) {
            echo 1;
            var_dump('aaaa');
            var_dump($e->getMessage());
            var_dump('aaaa');
            die;
        }
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
        foreach ($this->loadDestinationsClassesMapping($container) as $id => $metaReader) {
            if ($metaReader->skip() || !$metaReader->isDestination()) {
                continue;
            }

            $destinationRegistry->addMethodCall('registerDestinationClass', [$id]);
            $this
                ->registerDestinationRelations($container, $metaReader, $id)
                ->registerDestinationNaming($container, $metaReader, $id);
        }

        foreach ($this->loadSourcesClassesMapping($container) as $id => $metaReader) {
            if ($metaReader->skip() || !$metaReader->isSource()) {
                continue;
            }

            $destinationRegistry->addMethodCall('registerSourceClass', [$id]);
            $this
                ->registerSourceStrategy($container, $metaReader, $id)
                ->registerSourceNaming($container, $metaReader, $id)
                ->registerSourceRelations($container, $metaReader, $id);

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
    private function registerSourceNaming(
        ContainerBuilder $container,
        MappingMetaReader $reader,
        string $id
    ): self {
        $namingStrategyRegistry = $container->getDefinition(MappingRegistry\NamingStrategyRegistry::class);

        /** @var NamingStrategyInterface $namingStrategy */
        foreach ($reader->getSourceNamingStrategies() as $namingStrategy) {
            $key = TypeResolver::getStrategyType($id, TypeDict::ALL_TYPE);
            $namingStrategyDefinition = $this->createNamingStrategy($namingStrategy);
            if (!empty($namingStrategy->getSource())) {
                $key = TypeResolver::getStrategyType($id, $namingStrategy->getSource());
            }

            $namingStrategyRegistry->addMethodCall('registerNamingStrategy', [$key, $namingStrategyDefinition,]);
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
    private function registerSourceStrategy(
        ContainerBuilder $container,
        MappingMetaReader $reader,
        string $id
    ): self {
        $strategyRegistry = $container->getDefinition(MappingRegistry\StrategyRegistry::class);

        foreach ($reader->getPropertiesStrategies() as $propertyName => $strategy) {
            if (null === $this->createStrategyDefinition($container, $strategy)) {
                continue;
            }

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

        return $this;
    }

    /**
     * @param ContainerBuilder      $container
     * @param MetaStrategyInterface $strategy
     *
     * @return Definition
     */
    private function createStrategyDefinition(
        ContainerBuilder $container,
        MetaStrategyInterface $strategy
    ): Definition {

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
     * @param ContainerBuilder  $container
     * @param MappingMetaReader $reader
     * @param string            $id
     *
     * @return MappingCompilePass
     */
    private function registerDestinationNaming(
        ContainerBuilder $container,
        MappingMetaReader $reader,
        string $id
    ): self {
        $namingStrategyRegistry = $container->getDefinition(MappingRegistry\NamingStrategyRegistry::class);

        /** @var NamingStrategyInterface $namingStrategy */
        foreach ($reader->getDestinationNamingStrategies() as $namingStrategy) {
            // Default naming for array to dto mapping and dto to array extraction
            $key = TypeResolver::getStrategyType(TypeDict::ALL_TYPE, $id);
            $namingStrategyDefinition = $this->createNamingStrategy($namingStrategy);
            if (!empty($namingStrategy->getSource())) {
                $key = TypeResolver::getStrategyType($namingStrategy->getSource(), $id);
            }

            $namingStrategyRegistry->addMethodCall('registerNamingStrategy', [$key, $namingStrategyDefinition,]);
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
    private function registerDestinationRelations(
        ContainerBuilder $container,
        MappingMetaReader $reader,
        string $id
    ): self {
        $relationsRegistry = $container->getDefinition(MappingRegistry\RelationsRegistry::class);
        $strategyRegistry = $container->getDefinition(MappingRegistry\StrategyRegistry::class);

        /** @var EmbeddedInterface $embedded */
        foreach ($reader->getRelationsProperties() as $propertyName => $embedded) {
            $relationsRegistry->addMethodCall(
                'registerRelationsMapping',
                [
                    $propertyName,
                    $id,
                    $embedded->getTarget(),
                    $embedded->isMulti(),
                ]
            );

            $strategyKey = TypeResolver::getStrategyType(TypeDict::ARRAY_TYPE, $id);
            $strategyRegistry->addMethodCall(
                'registerPropertyStrategy',
                [
                    $strategyKey,
                    $propertyName,
                    new Reference(Strategy\SerializerStrategy::class),
                ]
            );
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
    private function registerSourceRelations(
        ContainerBuilder $container,
        MappingMetaReader $reader,
        string $id
    ): self {
        $relationsRegistry = $container->getDefinition(MappingRegistry\RelationsRegistry::class);
        $strategyRegistry = $container->getDefinition(MappingRegistry\StrategyRegistry::class);

        /** @var EmbeddedInterface $embedded */
        foreach ($reader->getRelationsProperties() as $propertyName => $embedded) {
            $relationsRegistry->addMethodCall(
                'registerRelationsMapping',
                [
                    $propertyName,
                    $id,
                    $embedded->getTarget(),
                    $embedded->isMulti(),
                ]
            );

            $strategyKey = TypeResolver::getStrategyType($id, TypeDict::ALL_TYPE);
            $strategyRegistry->addMethodCall(
                'registerPropertyStrategy',
                [
                    $strategyKey,
                    $propertyName,
                    new Reference(Strategy\CollectionStrategy::class),
                ]
            );
        }

        return $this;
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
    private function loadSourcesClassesMapping(ContainerBuilder $container): \Generator
    {
        foreach ($container->findTaggedServiceIds(self::DTO_MAPPER_SOURCE_TAG) as $id => $tag) {
            yield $id => $this->createReaderFor($container, $container->getDefinition($id)->getClass());
        }
    }

    /**
     * @throws \Exception
     *
     * @param ContainerBuilder $container
     *
     * @return \Generator
     */
    private function loadDestinationsClassesMapping(ContainerBuilder $container): \Generator
    {
        foreach ($container->findTaggedServiceIds(self::DTO_MAPPER_DESTINATION_TAG) as $id => $tag) {
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
