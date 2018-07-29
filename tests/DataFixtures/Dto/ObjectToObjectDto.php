<?php

namespace Tests\DataFixtures\Dto;

use Tests\DataFixtures\Model\Relations\MappedRelationsNodeInfo;
use VKMapperBundle\Annotation\MappingMeta\Strategy;
use VKMapperBundle\Annotation\MappingMeta\DestinationClass;

/**
 * Class ObjectToObjectDto
 * @DestinationClass
 */
class ObjectToObjectDto
{
    /**
     * @var MappedRelationsNodeInfo
     */
    private $nodeA;

    /**
     * @var MappedRelationsNodeInfo
     * @Strategy\GetterStrategy(
     *     source="Tests\DataFixtures\Model\Relations\RootSource",
     *     method="getMe"
     * )
     */
    private $nodeB;

    /**
     * @Strategy\GetterStrategy(
     *     source="Tests\DataFixtures\Model\Relations\RootSource",
     *     method="getMe"
     * )
     */
    public $testMe;
}
