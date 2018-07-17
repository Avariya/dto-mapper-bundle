<?php

namespace Tests\DataFixtures\Dto;

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\Strategy;

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
