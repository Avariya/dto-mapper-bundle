<?php

namespace Tests\DataFixtures\Dto\ObjectToObject;

use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class DtoNode
 * @SourceClass
 */
class DtoNode
{
    /**
     * @Strategy\GetterStrategy(method="getOptionA")
     */
    public $optionA = 1;

    /**
     * @Strategy\GetterStrategy(method="getOptionB")
     */
    public $optionB = 2;

    /**
     * @return string
     */
    public function getOptionA(): string
    {
        return 'Hello ' . $this->optionA .' A!';
    }

    /**
     * @return string
     */
    public function getOptionB(): string
    {
        return 'Hello ' . $this->optionB .' B!';
    }
}
