<?php

namespace Tests\DataFixtures\Model\Chain;

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
