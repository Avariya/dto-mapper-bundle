<?php

namespace Tests\DataFixtures\Dto;

use VK\DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\UnderscoreNamingStrategy;
use Tests\DataFixtures\Model\Extractor\UnderscoreInnerObject;

/**
 * Class ObjectToUnderscoreArrayDto
 * @DestinationClass
 * @UnderscoreNamingStrategy
 */
class ObjectToUnderscoreArrayDto
{
    /**
     * @var string
     */
    public $aOption = 'a';

    /**
     * @var string
     */
    public $bOption = 'b';

    /**
     * @var UnderscoreInnerObject
     */
    public $cOption;

    /**
     * ObjectToUnderscoreArray constructor.
     */
    public function __construct()
    {
        $this->cOption = new UnderscoreInnerObject();
    }
}
