<?php

namespace Tests\DataFixtures\Annotation;

use VKMapperBundle\Annotation\MappingMeta;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy;

/**
 * Class EmbeddedCollectionRoot
 *
 * @MappingMeta\DestinationClass(namingStrategies={
 *      @NamingStrategy\IdentityNamingStrategy(source="object")
 *  })
 */
class EmbeddedCollectionRootDTO
{
    /**
     * @var EmbeddedCollectionNodeDTO
     * @MappingMeta\EmbeddedClass(target="Tests\DataFixtures\Annotation\EmbeddedCollectionNodeDTO")
     */
    public $singleNode;

    /**
     * @var EmbeddedCollectionNodeDTO[]
     * @MappingMeta\EmbeddedCollection(target="Tests\DataFixtures\Annotation\EmbeddedCollectionNodeDTO")
     */
    public $multiNode = [];

    /**
     * @var int
     */
    public $testPropertyA = 0;

    /**
     * @var int
     */
    public $testPropertyB = 0;

    /**
     * @return EmbeddedCollectionNodeDTO
     */
    public function getSingleNode(): EmbeddedCollectionNodeDTO
    {
        return $this->singleNode;
    }

    /**
     * @return EmbeddedCollectionNodeDTO[]
     */
    public function getMultiNode(): array
    {
        return $this->multiNode;
    }

    /**
     * @return int
     */
    public function getTestPropertyA(): int
    {
        return $this->testPropertyA;
    }

    /**
     * @return int
     */
    public function getTestPropertyB(): int
    {
        return $this->testPropertyB;
    }
}
