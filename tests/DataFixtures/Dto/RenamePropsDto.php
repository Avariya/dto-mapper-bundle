<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\Map;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\MapNamingStrategy;

/**
 * Class RenamePropsDto
 * @DestinationClass(namingStrategies={
 *     @MapNamingStrategy(
 *      convert={
 *          @Map(from="some_A", to="propA"),
 *          @Map(from="some_B", to="propB"),
 *          @Map(from="some_C", to="propC")
 *     }
 *  )
 * })
 */
class RenamePropsDto
{
    public $propA = 1;
    public $propB = 2;
    public $propC = 3;
}
