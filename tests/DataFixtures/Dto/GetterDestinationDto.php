<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class DestinationDto
 * @DestinationClass
 */
class GetterDestinationDto
{
    /**
     * @Strategy\GetterStrategy(source="Tests\DataFixtures\Model\Getter\SourceObject", method="getSum")
     */
    public $sum;

    /**
     * @var int
     */
    public $innerValue = 13;
}
