<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class DestinationDto
 * @DestinationClass
 */
class ChainDestinationDto
{
    /**
     * @Strategy\ChainStrategy(
     *     source="Tests\DataFixtures\Model\Chain\ChainSource",
     *     list={
     *          @Strategy\GetterStrategy(method="getBaseValue"),
     *          @Strategy\StaticClosureStrategy(
     *              provider="Tests\DataFixtures\Model\Chain\ChainClosureProvider",
     *              method="multiply2"
     *          ),
     *          @Strategy\ServiceClosureStrategy(
     *                  provider="Tests\DataFixtures\Model\Chain\ChainClosureProvider",
     *                  method="multiplyOnInnerValue"
     *          ),
     *          @Strategy\ServiceClosureStrategy(
     *                  provider="Tests\DataFixtures\Model\Chain\ChainClosureProvider",
     *                  method="multiplyOnInnerValue"
     *          )
     * })
     */
    public $chainMappedProperty;
}
