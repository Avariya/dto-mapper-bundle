<?php

namespace Tests\DataFixtures\Dto;

use VK\DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;
use Tests\DataFixtures\Model\Extractor\SnakeCaseInnerObject;

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
