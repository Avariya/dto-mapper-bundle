<?php

namespace Tests\DataFixtures\Dto;

use VK\DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\Strategy;

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
