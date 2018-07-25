<?php

namespace Tests\DataFixtures\Dto;

use Tests\DataFixtures\Model\Extractor\UnderscoreInnerObject;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\UnderscoreNamingStrategy;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;

/**
 * Class ObjectToUnderscoreArrayDto
 * @SourceClass(namingStrategies={
 *     @UnderscoreNamingStrategy
 * })
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
