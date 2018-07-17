<?php

namespace Tests\DataFixtures\Model\Closure;

/**
 * Class ClosureSource
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
     * @return int
     */
    public function getSum(): int
    {
        return $this->optionA + $this->optionB;
    }
}
