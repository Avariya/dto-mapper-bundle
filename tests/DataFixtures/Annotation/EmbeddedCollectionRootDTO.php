<?php

namespace Tests\DataFixtures\Annotation;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedCollection;

/**
 * Class EmbeddedCollectionRoot
 *
 * @DestinationClass
 * @NamingStrategy\NamingRegister(for={
 *     @NamingStrategy\SnakeCaseNamingStrategy,
 *     @NamingStrategy\UnderscoreNamingStrategy(source="class"),
 * })
 * @NamingStrategy\IdentityNamingStrategy(source="object"),
 */
class EmbeddedCollectionRootDTO
{
    /**
     * @var EmbeddedCollectionNodeDTO
     * @EmbeddedClass(target="Tests\DataFixtures\Annotation\EmbeddedCollectionNodeDTO")
     */
    public $singleNode;

    /**
     * @var EmbeddedCollectionNodeDTO[]
     * @EmbeddedCollection(target="Tests\DataFixtures\Annotation\EmbeddedCollectionNodeDTO")
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
