<?php

namespace Tests\TestCase\Reader;

use Doctrine\Common\Annotations\AnnotationReader;
use DTOMapperBundle\Annotation\DestinationMetaReader;
use PHPUnit\Framework\TestCase;
use Tests\DataFixtures\Dto\EmbeddedCollectionRootDTO;

/**
 * Class ReaderRelationsTest
 */
class ReaderRelationsTest extends TestCase
{
    public function testRelationsAnnotationsParsing()
    {
        $reader = $this->createReader(EmbeddedCollectionRootDTO::class);
    }


    /**
     * @param string $className
     *
     * @return DestinationMetaReader
     */
    protected function createReader(string $className): DestinationMetaReader
    {
//        $reader = new FileCacheReader(
//            new AnnotationReader(),
//            "/path/to/cache",
//            $debug = true
//        );

        return DestinationMetaReader::createReader(
            new AnnotationReader(),
            $className
        );
    }
}
