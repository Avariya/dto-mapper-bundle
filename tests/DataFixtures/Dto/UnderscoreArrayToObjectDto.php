<?php

namespace Tests\DataFixtures\Dto;

use Tests\DataFixtures\Model\Extractor\UnderscoreInnerObject;
use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;

/**
 * Class UnderscoreArrayToObjectDto
 * @DestinationClass
 */
class UnderscoreArrayToObjectDto
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
     * @EmbeddedClass(target="Tests\DataFixtures\Model\Extractor\UnderscoreInnerObject")
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
