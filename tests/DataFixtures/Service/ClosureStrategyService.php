<?php

namespace Tests\DataFixtures\Service;

/**
 * Class ClosureStrategyService
 */
class ClosureStrategyService
{
    /**
     * @return \Closure
     */
    public static function getStaticClosure(): \Closure
    {
        return function () {
            return[ 1,2,3,4];
        };
    }
}
