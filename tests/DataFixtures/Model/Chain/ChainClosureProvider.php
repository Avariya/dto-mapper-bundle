<?php

namespace Tests\DataFixtures\Model\Chain;

/**
 * Class ChainClosureProvider
 */
class ChainClosureProvider
{
    /**
     * @var InnerScopeDependencySource
     */
    private $innerScopeObject;

    /**
     * ClosureProvider constructor.
     */
    public function __construct()
    {
        $this->innerScopeObject = new InnerScopeDependencySource();
    }

    /**
     * @return \Closure
     */
    public static function multiply2(): \Closure
    {
        return function (int $value): string {
            return $value * 2;
        };
    }

    /**
     * @return \Closure
     */
    public function multiplyOnInnerValue(): \Closure
    {
        return function (int $value): string {
            return $value * $this->innerScopeObject->getValue();
        };
    }
}
