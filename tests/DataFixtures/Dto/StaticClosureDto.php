<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

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
