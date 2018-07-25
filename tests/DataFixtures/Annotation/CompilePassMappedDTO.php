<?php

namespace Tests\DataFixtures\Annotation;

use VKMapperBundle\Annotation\MappingMeta;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class CompilePassMappedDTO
 * @MappingMeta\DestinationClass(namingStrategies={
 *      @NamingStrategy\MapNamingStrategy(
 *          convert={
 *              @NamingStrategy\Map(from="a", to="aa"),
 *              @NamingStrategy\Map(from="b", to="bb"),
 *              @NamingStrategy\Map(from="c", to="cc")
 *          },
 *          extract={
 *              @NamingStrategy\Map(from="a", to="aa"),
 *              @NamingStrategy\Map(from="a", to="aa"),
 *              @NamingStrategy\Map(from="a", to="aa"),
 *          }
 *      )
 *  })
 */
class CompilePassMappedDTO
{
    /**
     * @Strategy\ChainStrategy(list={
     *   @Strategy\GetterStrategy(method="getMe"),
     *   @Strategy\XPathStrategy(xPath="some.example.path")
     * })
     */
    public $testPropertyA;

    /**
     * @Strategy\GetterStrategy(method="getMe")
     */
    public $testPropertyC;

    /**
     * @Strategy\ServiceClosureStrategy(provider="serviceId",method="getClosure")
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
