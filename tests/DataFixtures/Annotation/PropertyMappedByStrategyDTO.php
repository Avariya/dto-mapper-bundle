<?php

namespace Tests\DataFixtures\Annotation;

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class PropertyMappedByStrategyDTO
 * @DestinationClass
 */
class PropertyMappedByStrategyDTO
{
    /**
     * @Strategy\ChainStrategy(
     *     source="testSource",
     *     list={
     *          @Strategy\GetterStrategy(source="ComeClass", method="getMe"),
     *          @Strategy\ServiceClosureStrategy(source="ComeClass", provider="serviceId", method="getClosure"),
     *          @Strategy\StaticClosureStrategy(source="ComeClass", provider="serviceId", method="getClosure"),
     *          @Strategy\XPathStrategy(source="ComeClass", xPath="some.example.path")
     * })
     */
    public $testPropertyA;

    /**
     * @Strategy\StrategyRegister(for={
     *      @Strategy\GetterStrategy(source="ComeClass", method="getMe"),
     *      @Strategy\ServiceClosureStrategy(source="ComeClass", provider="serviceId", method="getClosure"),
     *      @Strategy\StaticClosureStrategy(source="ComeClass", provider="serviceId", method="getClosure"),
     *      @Strategy\XPathStrategy(source="ComeClass", xPath="some.example.path"),
     *      @Strategy\ChainStrategy(
     *          source="ComeClass",
     *          list={
     *              @Strategy\GetterStrategy(source="ComeClass", method="getMe"),
     *              @Strategy\StaticClosureStrategy(source="ComeClass", provider="serviceId", method="getClosure"),
     *           }
     *      )
     * })
     * @Strategy\XPathStrategy(source="ComeClass", xPath="some.example.path")
     */
    public $testPropertyB;

    /**
     * @Strategy\GetterStrategy(source="ComeClass", method="getMe")
     */
    public $testPropertyC;

    /**
     * @Strategy\ServiceClosureStrategy(source="ComeClass", provider="serviceId", method="getClosure")
     */
    public $testPropertyD;

    /**
     * @Strategy\StaticClosureStrategy(source="ComeClass", provider="serviceId", method="getClosure")
     */
    public $testPropertyE;

    /**
     * @Strategy\XPathStrategy(source="ComeClass", xPath="some.example.path")
     */
    public $testPropertyF;
}
