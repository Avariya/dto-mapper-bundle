<?php

namespace Tests\TestCase\Traits;

use Doctrine\Common\Annotations\AnnotationReader;
use DTOMapperBundle\Annotation\MappingMetaReader;

/**
 * Trait ReaderTrait
 */
trait ReaderTrait
{
    /**
     * @param string $className
     *
     * @return MappingMetaReader
     */
    protected function createReader(string $className): MappingMetaReader
    {
        $reader = new AnnotationReader();
        $reader::addGlobalIgnoredName('\DTOMapperBundle\Annotation\MappingMeta\DestinationClass');

        return MappingMetaReader::createReader(
            $reader,
            $className
        );
    }
}
