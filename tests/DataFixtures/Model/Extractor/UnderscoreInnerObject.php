<?php

namespace Tests\DataFixtures\Model\Extractor;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;

/**
 * Class UnderscoreInnerObject
 * @DestinationClass
 * @SourceClass
 */
class UnderscoreInnerObject
{
    /**
     * @var string
     */
    public $aOption = 'a';

    /**
     * @var string
     */
    public $bOption = 'b';
}
