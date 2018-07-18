<?php

namespace Tests\DataFixtures\Annotation;

use VK\DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\EmbeddedClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\NamingStrategy;
use VK\DTOMapperBundle\Annotation\MappingMeta\EmbeddedCollection;

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
