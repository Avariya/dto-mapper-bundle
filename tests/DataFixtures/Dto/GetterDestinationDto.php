<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;

/**
 * Class DestinationDto
 * @DestinationClass
 */
class GetterDestinationDto
{
    public $sum;

    /**
     * @var int
     */
    public $innerValue = 13;
}
