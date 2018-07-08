<?php

namespace Tests\DataFixtures\Dto;

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy;
use DTOMapperBundle\Annotation\MappingMeta\EmbeddedCollection;

/**
 * Class EmbeddedCollectionRoot
 *
 * @DestinationClass
 * @NamingStrategy\NamingRegister(for={
 *     @NamingStrategy\SnakeCaseNamingStrategy(source="array"),
 *     @NamingStrategy\UnderscoreNamingStrategy(source="class"),
 * })
 * @NamingStrategy\IdentityNamingStrategy(source="object"),
 */
class EmbeddedCollectionRootDTO
{
    /**
     * @var EmbeddedCollectionNodeDTO
     * @EmbeddedCollection(
     *      target="\Tests\DataFixtures\Dto\EmbeddedCollectionNodeDTO"
     *  )
     */
    public $singleNode;

    /**
     * @var EmbeddedCollectionNodeDTO[]
     * @EmbeddedCollection(
     *     target="\Tests\DataFixtures\Dto\EmbeddedCollectionNodeDTO",
     *     multi=true
     * )
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
