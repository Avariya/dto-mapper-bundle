<?php

namespace Tests\DataFixtures\Dto;

use Tests\DataFixtures\Model\Extractor\SnakeCaseInnerObject;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;

/**
 * Class ObjectToSnakeCaseArrayDto
 * @SourceClass
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
