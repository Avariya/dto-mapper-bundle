<?php

namespace Tests\DataFixtures\Dto;

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\Strategy;

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
