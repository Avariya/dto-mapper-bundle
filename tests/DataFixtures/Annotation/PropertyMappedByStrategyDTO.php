<?php

namespace Tests\DataFixtures\Annotation;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

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
     *      @Strategy\GetterStrategy(source="Tests\DataFixtures\Model\GeneralSource", method="getMe"),
     *      @Strategy\ServiceClosureStrategy(
     *          source="Tests\DataFixtures\Model\GeneralSource",
     *          provider="serviceId",
     *          method="getClosure"
     *      ),
     *      @Strategy\StaticClosureStrategy(
     *              source="Tests\DataFixtures\Model\GeneralSource",
     *              provider="Tests\DataFixtures\Service\ClosureStrategyService",
     *              method="getStaticClosure"
     *      ),
     *      @Strategy\XPathStrategy(source="Tests\DataFixtures\Model\GeneralSource", xPath="some.example.path"),
     *      @Strategy\ChainStrategy(
     *          source="Tests\DataFixtures\Model\GeneralSource",
     *          list={
     *              @Strategy\GetterStrategy(method="getMe"),
     *              @Strategy\StaticClosureStrategy(
     *                  provider="Tests\DataFixtures\Service\ClosureStrategyService",
     *                  method="getStaticClosure"
     *              ),
     *           }
     *      )
     * })
     * @Strategy\XPathStrategy(source="Tests\DataFixtures\Model\GeneralSource", xPath="some.example.path")
     */
    public $testPropertyB;

    /**
     * @Strategy\GetterStrategy(source="Tests\DataFixtures\Model\GeneralSource", method="getMe")
     */
    public $testPropertyC;

    /**
     * @Strategy\ServiceClosureStrategy(
     *     source="Tests\DataFixtures\Model\GeneralSource",
     *     provider="serviceId",
     *     method="getClosure"
     * )
     */
    public $testPropertyD;

    /**
     * @Strategy\StaticClosureStrategy(
     *     source="Tests\DataFixtures\Model\GeneralSource",
     *     provider="Tests\DataFixtures\Service\ClosureStrategyService",
     *     method="getStaticClosure"
     * )
     */
    public $testPropertyE;

    /**
     * @Strategy\XPathStrategy(source="Tests\DataFixtures\Model\GeneralSource", xPath="some.example.path")
     */
    public $testPropertyF;
}
