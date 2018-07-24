<?php

namespace Tests\DataFixtures\Model\Getter;

use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class SourceObject
 * @SourceClass
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
     * @Strategy\GetterStrategy(method="getSum")
     */
    public $sum;

    /**
     * @Strategy\PropertyFormatterStrategy(method="getFormattedValue")
     */
    public $formatted = 100;

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->a + $this->b + $this->c;
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public function getFormattedValue(int $value): string
    {
        return $value . '- formatted';
    }
}
