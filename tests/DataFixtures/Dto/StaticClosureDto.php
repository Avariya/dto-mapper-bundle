<?php

namespace Tests\DataFixtures\Dto;

use VK\DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class DestinationClass
 * @DestinationClass
 */
class StaticClosureDto
{
    /**
     * @Strategy\StaticClosureStrategy(
     *     source="Tests\DataFixtures\Model\Closure\ClosureSource",
     *     provider="Tests\DataFixtures\Model\Closure\ClosureProvider",
     *     method="getStaticClosure"
     * )
     */
    public $myValue;
}
