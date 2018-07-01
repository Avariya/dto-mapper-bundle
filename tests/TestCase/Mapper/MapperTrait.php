<?php

namespace Tests\TestCase\Mapper;

use MapperBundle\Hydrator\AbstractHydrator;
use MapperBundle\Hydrator\ArraySerializableHydrator;
use MapperBundle\Hydrator\HydratorFactory;
use MapperBundle\Hydrator\HydratorRegistry;
use MapperBundle\Hydrator\NamingStrategy\NamingStrategyInterface;
use MapperBundle\Hydrator\Strategy\PropertyCollectionRelatingStrategy;
use MapperBundle\Mapper\Mapper;
use MapperBundle\Mapping\MappingRegistry;

use Doctrine\Common\Annotations\AnnotationReader;
use Tests\DataFixtures\Dto\RelationsRequestDto;

/**
 * Trait MapperTrait
 */
trait MapperTrait
{
    /**
     * @param NamingStrategyInterface|null $namingStrategy
     *
     * @return Mapper
     */
    protected function createMapper(NamingStrategyInterface $namingStrategy = null): Mapper
    {
        $mappingRegistry = $this->createMappingRegistry();
        $hydratorRegistry = new HydratorRegistry();
        $baseHydrator = $this->createBaseHydrator($namingStrategy);
        $hydratorRegistry->registerHydrator($baseHydrator, '*');

        $relationHydrator = $this->createBaseHydrator($namingStrategy);
        $relationsStrategy = new PropertyCollectionRelatingStrategy($relationHydrator, $mappingRegistry);
        $relationHydrator->addStrategy(PropertyCollectionRelatingStrategy::class, $relationsStrategy);
        $hydratorRegistry->registerHydrator($relationHydrator, 'array:string');

        $hydratorFactory = new HydratorFactory($hydratorRegistry, $mappingRegistry);

        return new Mapper($hydratorFactory);
    }

    /**
     * @param NamingStrategyInterface|null $namingStrategy
     *
     * @return AbstractHydrator
     */
    private function createBaseHydrator(NamingStrategyInterface $namingStrategy = null): AbstractHydrator
    {
        $arrayHydrator = new ArraySerializableHydrator();

        if ($namingStrategy !== null) {
            $arrayHydrator->setNamingStrategy($namingStrategy);
        }

        return $arrayHydrator;
    }

    /**
     * @return MappingRegistry
     */
    private function createMappingRegistry(): MappingRegistry
    {
        $mappedFixtures = [
            RelationsRequestDto::class,
        ];

        $mappingRegistry = new MappingRegistry(new AnnotationReader());
        foreach ($mappedFixtures as $className) {
            $mappingRegistry->registerMappedDestinationClass($className);
        }

        return $mappingRegistry;
    }
}
