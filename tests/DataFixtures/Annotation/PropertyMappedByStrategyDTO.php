<?php

namespace Tests\DataFixtures\Annotation;

use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class PropertyMappedByStrategyDTO
 * @SourceClass
 */
class PropertyMappedByStrategyDTO
{
    /**
     * @Strategy\ChainStrategy(
     *     list={
     *          @Strategy\GetterStrategy(method="getMe"),
     *          @Strategy\ServiceClosureStrategy(
     *                  provider="serviceId",
     *                  method="getClosure"
     *          ),
     *          @Strategy\StaticClosureStrategy(
     *              provider="Tests\DataFixtures\Service\ClosureStrategyService",
     *              method="getStaticClosure"
     *          ),
     *          @Strategy\XPathStrategy(xPath="some.example.path")
     * })
     */
    public $testPropertyA;

    /**
     * @Strategy\StrategyRegister(for={
     *      @Strategy\GetterStrategy(method="getMe"),
     *      @Strategy\ServiceClosureStrategy(provider="serviceId",method="getClosure"),
     *      @Strategy\StaticClosureStrategy(
     *              provider="Tests\DataFixtures\Service\ClosureStrategyService",
     *              method="getStaticClosure"
     *      ),
     *      @Strategy\XPathStrategy(xPath="some.example.path"),
     *      @Strategy\ChainStrategy(
     *          list={
     *              @Strategy\GetterStrategy(method="getMe"),
     *              @Strategy\StaticClosureStrategy(
     *                  provider="Tests\DataFixtures\Service\ClosureStrategyService",
     *                  method="getStaticClosure"
     *              ),
     *           }
     *      )
     * })
     * @Strategy\XPathStrategy(xPath="some.example.path")
     */
    public $testPropertyB;

    /**
     * @Strategy\GetterStrategy(method="getMe")
     */
    public $testPropertyC;

    /**
     * @Strategy\ServiceClosureStrategy(
     *     provider="serviceId",
     *     method="getClosure"
     * )
     */
    public $testPropertyD;

    /**
     * @Strategy\StaticClosureStrategy(
     *     provider="Tests\DataFixtures\Service\ClosureStrategyService",
     *     method="getStaticClosure"
     * )
     */
    public $testPropertyE;

    /**
     * @Strategy\XPathStrategy(xPath="some.example.path")
     */
    public $testPropertyF;
}
