<?php

namespace Tests\TestCase\Annotation;

use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\AbstractNamingStrategy;
use Tests\DataFixtures\Annotation\EmbeddedCollectionRootDTO;
use PHPUnit\Framework\TestCase;
use Tests\TestCase\Traits\ReaderTrait;

/**
 * Class NamingStrategyAnnotationsReaderTest
 */
class NamingStrategyAnnotationsReaderTest extends TestCase
{
    use ReaderTrait;

    /**
     *
     */
    public function testRelationsAnnotationsParsing(): void
    {
        $reader = $this->createReader(EmbeddedCollectionRootDTO::class);
        $namingStrategies = $reader->getNamingStrategies();
        $this->assertContainsOnlyInstancesOf(AbstractNamingStrategy::class, $namingStrategies);
    }
}
