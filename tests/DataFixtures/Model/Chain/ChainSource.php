<?php

namespace Tests\DataFixtures\Model\Chain;

/**
 * Class ChainSource
 */
class ChainSource
{
    /**
     * @var int
     */
    public $baseValue = 1;

    /**
     * @return int
     */
    public function getBaseValue(): int
    {
        return $this->baseValue;
    }
}
