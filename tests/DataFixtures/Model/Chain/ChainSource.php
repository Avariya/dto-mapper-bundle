<?php

namespace Tests\DataFixtures\Model\Chain;

use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class ChainSource
 * @SourceClass
 */
class ChainSource
{
    /**
     * @var int
     */
    public $baseValue = 1;

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

    /**
     * @return int
     */
    public function getBaseValue(): int
    {
        return $this->baseValue;
    }
}
