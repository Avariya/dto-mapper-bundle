<?php

namespace Tests\DataFixtures\Model\Closure;

use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class ClosureSource
 * @SourceClass
 */
class ClosureSource
{
    /**
     * @var int
     */
    public $optionA = 12;

    /**
     * @var int
     */
    public $optionB = 13;

    /**
     * @Strategy\ServiceClosureStrategy(
     *     provider="Tests\DataFixtures\Model\Closure\ClosureProvider",
     *     method="getClosure"
     * )
     */
    public $myValue;

    /**
     * @Strategy\StaticClosureStrategy(
     *     provider="Tests\DataFixtures\Model\Closure\ClosureProvider",
     *     method="getStaticClosure"
     * )
     */
    public $myValueB;

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->optionA + $this->optionB;
    }
}
