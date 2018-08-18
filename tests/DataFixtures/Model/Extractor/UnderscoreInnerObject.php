<?php

namespace Tests\DataFixtures\Model\Extractor;

use VKMapperBundle\Annotation\MappingMeta\MappedClass;

/**
 * Class UnderscoreInnerObject
 * @MappedClass()
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
