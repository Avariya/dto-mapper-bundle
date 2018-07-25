<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class DtoObjectToObjectNodeA
 * @SourceClass
 */
class DtoObjectToObjectNodeA
{
    /**
     * @Strategy\GetterStrategy(method="getA")
     */
    public $optionA;

    /**
     * @Strategy\GetterStrategy(method="getB")
     */
    public $optionB;

    /**
     * @Strategy\GetterStrategy(method="getC")
     */
    public $optionC;

    /**
     * @return string
     */
    public function getA(): string
    {
        return 'Hello from a!';
    }
    /**
     * @return string
     */
    public function getB(): string
    {
        return 'Hello from b!';
    }
    /**
     * @return string
     */
    public function getC(): string
    {
        return 'Hello from c!';
    }
}
