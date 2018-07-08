<?php

namespace Tests\TestCase\Traits;

use Doctrine\Common\Annotations\AnnotationReader;
use DTOMapperBundle\Annotation\DestinationMetaReader;

/**
 * Trait ReaderTrait
 */
trait ReaderTrait
{
    /**
     * @param string $className
     *
     * @return DestinationMetaReader
     */
    protected function createReader(string $className): DestinationMetaReader
    {
        return DestinationMetaReader::createReader(
            new AnnotationReader(),
            $className
        );
    }
}
