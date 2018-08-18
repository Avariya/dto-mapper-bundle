<?php

namespace Tests\DataFixtures\Model\Extractor;

use VKMapperBundle\Annotation\MappingMeta\MappedClass;

/**
 * Class SnakeCaseInnerObject
 * @MappedClass()
 */
class SnakeCaseInnerObject
{
    /**
     * @var string
     */
    public $a_option = 'a';

    /**
     * @var string
     */
    public $b_option = 'b';
}
