<?php

namespace DTOMapperBundle\DependencyInjection\Compiler;

use DataMapper\Type\TypeDict;
use DTOMapperBundle\Annotation\Exception\InvalidTypeException;
use DTOMapperBundle\StrategyAdapter\StaticClosureStrategyAdapter;
use DTOMapperBundle\StrategyAdapter\ServiceClosureStrategyAdapter;
use DTOMapperBundle\Annotation\MappingMetaReader;
use DTOMapperBundle\Annotation\AnnotationReaderInterface;
use DTOMapperBundle\Annotation\MappingMeta\Strategy as MetaStrategy;
use DTOMapperBundle\Annotation\MappingMeta\Strategy\StrategyInterface as MetaStrategyInterface;

use DataMapper\Strategy;
use DataMapper\Hydrator\CollectionHydrator;
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

        foreach ($this->loadDestinationsClassesMapping($container) as $destinationClassName => $metaReader) {
            $destinationRegistry->addMethodCall('registerDestinationClass', [$destinationClassName]);

            $this
                ->registerRelations($container, $metaReader, $destinationClassName)
                ->registerNaming($container, $metaReader, $destinationClassName)
                ->registerStrategy($container, $metaReader, $destinationClassName);
        }

        return $this;
    }

    /**
     * @param ContainerBuilder  $container
     * @param MappingMetaReader $reader
     * @param string            $destination
     *
     * @return MappingCompilePass
     */
    private function registerRelations(
        ContainerBuilder $container,
        MappingMetaReader $reader,
        string $destination
    ): self {
        $relationsRegistry = $container->getDefinition(MappingRegistry\RelationsRegistry::class);
        $strategyRegistry = $container->getDefinition(MappingRegistry\StrategyRegistry::class);

        foreach ($reader->getRelationsProperties() as $propertyName => $embedded) {
            $relationsRegistry->addMethodCall(
                'registerRelationsMapping',
                [
                    $propertyName,
                    $destination,
                    $embedded->getTarget(),
                    $embedded->isMulti(),
                ]
            );

            $strategyRegistry->addMethodCall(
                'registerPropertyStrategy',
                [
                    TypeResolver::getStrategyType(TypeDict::ARRAY_TYPE, $destination),
                    $propertyName,
                    (new Definition(
                        Strategy\CollectionStrategy::class,
                        [
                            new Reference(CollectionHydrator::class),
                            new Reference(MappingRegistry\RelationsRegistryInterface::class),
                        ]
                    ))->setLazy(true),
                ]
            );
        }

        return $this;
    }

    /**
     * @param ContainerBuilder  $container
     * @param MappingMetaReader $reader
     * @param string            $destination
     *
     * @return MappingCompilePass
     */
    private function registerNaming(ContainerBuilder $container, MappingMetaReader $reader, string $destination): self
    {
        $namingStrategyRegistry = $container->getDefinition(MappingRegistry\NamingStrategyRegistry::class);
        foreach ($reader->getNamingStrategies() as $namingStrategy) {
            if (!empty($namingStrategy->getSource())) {
                $namingStrategyRegistry->addMethodCall(
                    'registerNamingStrategy',
                    [
                        TypeResolver::getStrategyType($namingStrategy->getSource(), $destination),
                        new Reference($namingStrategy->getStrategyClassName()),
                    ]
                );

                continue;
            }

            // Register default naming for array to dto mapping and dto to array extraction
            $namingStrategyRegistry->addMethodCall(
                'registerNamingStrategy',
                [
                    TypeResolver::getStrategyType(TypeDict::ARRAY_TYPE, $destination),
                    new Reference($namingStrategy->getStrategyClassName()),
                ]
            );

            $namingStrategyRegistry->addMethodCall(
                'registerNamingStrategy',
                [
                    TypeResolver::getStrategyType($destination, TypeDict::ARRAY_TYPE),
                    new Reference($namingStrategy->getStrategyClassName()),
                ]
            );
        }

        return $this;
    }

    /**
     * @param ContainerBuilder  $container
     * @param MappingMetaReader $reader
     * @param string            $destination
     *
     * @return self
     */
    private function registerStrategy(ContainerBuilder $container, MappingMetaReader $reader, string $destination): self
    {
        $strategyRegistry = $container->getDefinition(MappingRegistry\StrategyRegistry::class);

        foreach ($reader->getPropertiesStrategies() as $propertyName => $strategy) {
            $strategyRegistry->addMethodCall(
                'registerPropertyStrategy',
                [
                    TypeResolver::getStrategyType($strategy->getSource(), $destination),
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
    private function createStrategyDefinition(ContainerBuilder $container, MetaStrategyInterface $strategy): Definition
    {
        if ($strategy instanceof MetaStrategy\GetterStrategy) {
            return (new Definition(
                Strategy\GetterStrategy::class,
                [
                    $strategy->getMethod()
                ]
            ))->setLazy(true);
        }

        if ($strategy instanceof MetaStrategy\XPathStrategy) {
            return (new Definition(
                Strategy\XPathGetterStrategy::class,
                [
                    new Reference(CollectionHydrator::class),
                    $strategy->getXPath(),
                ]
            ))->setLazy(true);
        }

        if ($strategy instanceof MetaStrategy\StaticClosureStrategy) {
            return (
                new Definition(
                    StaticClosureStrategyAdapter::class,
                    [
                       $strategy->getProvider(),
                       $strategy->getMethod(),
                    ]
                ))->setLazy(true);
        }

        if ($strategy instanceof MetaStrategy\ChainStrategy) {
            $args = [];

            foreach ($strategy->getList() as $singleStrategy) {
                $args[] = $this->createStrategyDefinition($container, $singleStrategy);
            }

            return (new Definition(
                Strategy\ChainStrategy::class,
                [$args]
            ))->setLazy(true);
        }

        if ($strategy instanceof MetaStrategy\ServiceClosureStrategy) {
            return (new Definition(
                ServiceClosureStrategyAdapter::class,
                [
                    new Reference($strategy->getProvider()),
                    $strategy->getMethod(),
                ]
            ))->setLazy(true);
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
