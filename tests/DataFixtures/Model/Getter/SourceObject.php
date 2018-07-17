<?php

namespace Tests\DataFixtures\Model\Getter;

/**
 * Class DestinationDtoClass
 */
class SourceObject
{
    /**
     * @var int
     */
    public $a = 100;

    /**
     * @var int
     */
    public $b = 200;

    /**
     * @var int
     */
    public $c = 300;

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->a + $this->b + $this->c;
    }
}
