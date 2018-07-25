<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;

/**
 * Class DtoObjectToObject
 * @SourceClass
 */
class DtoObjectToObject
{
    /**
     * @var MappedRelationsNodeDto
     * @EmbeddedClass(target="Tests\DataFixtures\Model\Relations\DtoToObjectSourceConvertedProp")
     */
    public $nodeA;

    public function __construct()
    {
        $this->nodeA = new DtoObjectToObjectNodeA();
    }
}
