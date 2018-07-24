<?php

namespace Tests\DataFixtures\Annotation;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class CompilePassMappedDTO
 * @DestinationClass
 */
class CompilePassMappedDTO
{
    /**
     * @Strategy\ChainStrategy(
     *     list={
     *          @Strategy\GetterStrategy(method="getMe"),
     *          @Strategy\XPathStrategy(xPath="some.example.path")
     * })
     */
    public $testPropertyA;

    /**
     * @Strategy\StrategyRegister(for={
     *      @Strategy\GetterStrategy(method="getMe")
     * })
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
