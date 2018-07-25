<?php

namespace Tests\TestCase\Annotation;

use Tests\DataFixtures\Annotation\CompilePassMappedDTO;
use Tests\DataFixtures\Annotation\EmbeddedCollectionRootDTO;
use Tests\TestCase\Traits\ReaderTrait;

use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\AbstractNamingStrategy;
use PHPUnit\Framework\TestCase;

/**
 * Class NamingStrategyAnnotationsReaderTest
 */
class NamingStrategyAnnotationsReaderTest extends TestCase
{
    use ReaderTrait;

    /**
     */
    public function testRelationsAnnotationsParsing(): void
    {
        $reader = $this->createReader(EmbeddedCollectionRootDTO::class);
        $namingStrategies = $reader->getDestinationNamingStrategies();
        $this->assertContainsOnlyInstancesOf(AbstractNamingStrategy::class, $namingStrategies);
    }

//    /**
//     */
//    public function testMapNamingStrategyParsing(): void
//    {
//        $reader = $this->createReader(CompilePassMappedDTO::class);
//        $namingStrategies = $reader->getNamingStrategies();
//        $this->assertContainsOnlyInstancesOf(AbstractNamingStrategy::class, $namingStrategies);
//    }
}
