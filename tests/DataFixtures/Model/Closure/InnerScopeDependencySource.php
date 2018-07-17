<?php

namespace Tests\DataFixtures\Model\Closure;

/**
 * Class InnerScopeDependencySource
 */
class InnerScopeDependencySource
{
    /**
     * @return int
     */
    public function getValue(): int
    {
        return 100;
    }
}
