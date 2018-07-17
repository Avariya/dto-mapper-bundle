<?php

namespace Tests\DataFixtures\Annotation;

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class CompilePassMappedDTO
 * @DestinationClass
 */
class CompilePassMappedDTO
{
    /**
     * @Strategy\ChainStrategy(
     *     source="testSource",
     *     list={
     *          @Strategy\GetterStrategy(method="getMe"),
     *          @Strategy\XPathStrategy(xPath="some.example.path")
     * })
     */
    public $testPropertyA;

    /**
     * @Strategy\StrategyRegister(for={
     *      @Strategy\GetterStrategy(source="Tests\DataFixtures\Model\GeneralSource", method="getMe")
     * })
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
