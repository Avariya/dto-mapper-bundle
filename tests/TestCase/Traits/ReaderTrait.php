<?php

namespace Tests\TestCase\Traits;

use Doctrine\Common\Annotations\AnnotationReader;
use VK\DTOMapperBundle\Annotation\MappingMetaReader;

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
        return MappingMetaReader::createReader(
            new AnnotationReader(),
            $className
        );
    }
}
