<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use Tests\DataFixtures\Model\Extractor\SnakeCaseInnerObject;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;

/**
 * Class ObjectToSnakeCaseArrayDto
 * @DestinationClass
 * @SnakeCaseNamingStrategy
 */
class ObjectToSnakeCaseArrayDto
{
    /**
     * @var string
     */
    public $a_option = 'a';

    /**
     * @var string
     */
    public $b_option = 'b';

    /**
     * @var SnakeCaseInnerObject
     */
    public $c_option;

    /**
     * ObjectToSnakeCaseArray constructor.
     */
    public function __construct()
    {
        $this->c_option = new SnakeCaseInnerObject;
    }
}
