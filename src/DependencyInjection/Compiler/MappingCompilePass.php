<?php

namespace VKMapperBundle\DependencyInjection\Compiler;

use DataMapper\Strategy\CollectionStrategy;
use DataMapper\Type\TypeDict;
use VKMapperBundle\Annotation\Exception\InvalidTypeException;
use VKMapperBundle\StrategyAdapter\StaticClosureStrategyAdapter;
use VKMapperBundle\StrategyAdapter\ServiceClosureStrategyAdapter;
use VKMapperBundle\Annotation\MappingMetaReader;
use VKMapperBundle\Annotation\AnnotationReaderInterface;
use VKMapperBundle\Annotation\MappingMeta\Strategy as MetaStrategy;
use VKMapperBundle\Annotation\MappingMeta\Strategy\StrategyInterface as MetaStrategyInterface;

use DataMapper\Strategy;
use DataMapper\Hydrator\ArrayCollectionHydrator;
use DataMapper\Hydrator\ArraySerializableHydrator;
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
            $hydrationRegistry->addMethodCall(
                'registerHydrator',
                [
                    new Reference($hydratorClass),
                    $type,
                ]
            );
        }

        foreach ($container->findTaggedServiceIds(self::DTO_MAPPER_HYDRATOR_TAG) as $id => $tag) {
            if (!isset($tag['type'])) {
                throw new InvalidTypeException("You must register hydrator type for: $id");
            }

            $hydrationRegistry->addMethodCall(
                'registerHydrator',
                [
                    new Reference($id),
                    $tag['type'],
                ]
            );
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

        foreach ($this->loadDestinationsClassesMapping($container) as $id => $metaReader) {
            if ($metaReader->skip()) {
                continue;
            }

            $destinationRegistry->addMethodCall('registerDestinationClass', [$id]);
            $this
                ->registerDestinationRelations($container, $metaReader, $id)
                ->registerDestinationNaming($container, $metaReader, $id);
        }

        foreach ($this->loadSourcesClassesMapping($container) as $id => $metaReader) {
            if ($metaReader->skip()) {
                continue;
            }

            $destinationRegistry->addMethodCall('registerSourceClass', [$id]);
            $this
                ->registerSourceStrategy($container, $metaReader, $id)
                ->registerSourceNaming($container, $metaReader, $id);
//                ->registerRelations($container, $metaReader, $id)

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

        foreach ($reader->getNamingStrategies() as $namingStrategy) {
            if (!empty($namingStrategy->getSource())) {
                $namingStrategyRegistry->addMethodCall(
                    'registerNamingStrategy',
                    [
                        TypeResolver::getStrategyType($id, $namingStrategy->getSource()),
                        new Reference($namingStrategy->getStrategyClassName()),
                    ]
                );

                continue;
            }

            $namingStrategyRegistry->addMethodCall(
                'registerNamingStrategy',
                [
                    TypeResolver::getStrategyType($id, TypeDict::ALL_TYPE),
                    new Reference($namingStrategy->getStrategyClassName()),
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

            $strategyRegistry->addMethodCall(
                'registerPropertyStrategy',
                [
                    TypeResolver::getStrategyType($id, TypeDict::ALL_TYPE),
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
        if ($strategy instanceof MetaStrategy\GetterStrategy) {
            return (new Definition(Strategy\GetterStrategy::class, [$strategy->getMethod()]))->setLazy(true);
        }

        if ($strategy instanceof MetaStrategy\PropertyFormatterStrategy) {
            return (new Definition(Strategy\FormatterStrategy::class, [$strategy->getMethod()]))->setLazy(true);
        }

        if ($strategy instanceof MetaStrategy\XPathStrategy) {
            return (new Definition(
                Strategy\XPathGetterStrategy::class,
                [new Reference(ArrayCollectionHydrator::class), $strategy->getXPath()]
            ))->setLazy(true);
        }

        if ($strategy instanceof MetaStrategy\StaticClosureStrategy) {
            return (
                new Definition(
                    StaticClosureStrategyAdapter::class,
                    [$strategy->getProvider(), $strategy->getMethod(),]
                ))->setLazy(true);
        }

        if ($strategy instanceof MetaStrategy\ChainStrategy) {
            $args = [];

            foreach ($strategy->getList() as $singleStrategy) {
                $args[] = $this->createStrategyDefinition($container, $singleStrategy);
            }

            return (new Definition(Strategy\ChainStrategy::class, [$args]))->setLazy(true);
        }

        if ($strategy instanceof MetaStrategy\ServiceClosureStrategy) {
            return (new Definition(
                ServiceClosureStrategyAdapter::class,
                [new Reference($strategy->getProvider()), $strategy->getMethod(),]
            ))->setLazy(true);
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
        foreach ($reader->getNamingStrategies() as $namingStrategy) {
            if (!empty($namingStrategy->getSource())) {
                $namingStrategyRegistry->addMethodCall(
                    'registerNamingStrategy',
                    [
                        TypeResolver::getStrategyType($namingStrategy->getSource(), $id),
                        new Reference($namingStrategy->getStrategyClassName()),
                    ]
                );

                continue;
            }

            // Register default naming for array to dto mapping and dto to array extraction
            $namingStrategyRegistry->addMethodCall(
                'registerNamingStrategy',
                [
                    TypeResolver::getStrategyType(TypeDict::ALL_TYPE, $id),
                    new Reference($namingStrategy->getStrategyClassName()),
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
    private function registerDestinationRelations(
        ContainerBuilder $container,
        MappingMetaReader $reader,
        string $id
    ): self {
        $relationsRegistry = $container->getDefinition(MappingRegistry\RelationsRegistry::class);
        $strategyRegistry = $container->getDefinition(MappingRegistry\StrategyRegistry::class);

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

            $strategyRegistry->addMethodCall(
                'registerPropertyStrategy',
                [
                    TypeResolver::getStrategyType(TypeDict::ARRAY_TYPE, $id),
                    $propertyName,
                    new Reference(Strategy\SerializerStrategy::class),
                ]
            );
        }

        return $this;
    }

//    /**
//     * @param ContainerBuilder  $container
//     * @param MappingMetaReader $reader
//     * @param string            $destination
//     *
//     * @return MappingCompilePass
//     */
//    private function registerRelations(
//        ContainerBuilder $container,
//        MappingMetaReader $reader,
//        string $destination
//    ): self {
//        $relationsRegistry = $container->getDefinition(MappingRegistry\RelationsRegistry::class);
//        $strategyRegistry = $container->getDefinition(MappingRegistry\StrategyRegistry::class);
//
//        foreach ($reader->getRelationsProperties() as $propertyName => $embedded) {
//            $relationsRegistry->addMethodCall(
//                'registerRelationsMapping',
//                [
//                    $propertyName,
//                    $destination,
//                    $embedded->getTarget(),
//                    $embedded->isMulti(),
//                ]
//            );
//
//            $strategyRegistry->addMethodCall(
//                'registerPropertyStrategy',
//                [
//                    TypeResolver::getStrategyType(TypeDict::ARRAY_TYPE, $destination),
//                    $propertyName,
//                    new Reference(Strategy\SerializerStrategy::class),
//                ]
//            );
//        }
//
//        return $this;
//    }

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
