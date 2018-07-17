<?php

namespace Tests\DataFixtures\Model\Closure;

/**
 * Class ClosureProvider
 */
class ClosureProvider
{
    private const TEXT = '- mapped by ClosureProvider';

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
    public static function getStaticClosure(): \Closure
    {
        return function (ClosureSource $source): string {
            return $source->getSum() . self::TEXT;
        };
    }

    /**
     * @return \Closure
     */
    public function getClosure(): \Closure
    {
        return function (ClosureSource $source): string {
            return ($source->getSum() + $this->innerScopeObject->getValue()) . self::TEXT;
        };
    }

    /**
     * @return string
     */
    public static function getText(): string
    {
        return self::TEXT;
    }
}
