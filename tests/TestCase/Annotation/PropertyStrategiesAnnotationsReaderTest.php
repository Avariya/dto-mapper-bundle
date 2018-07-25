<?php

namespace Tests\TestCase\Annotation;

use VKMapperBundle\Annotation\MappingMeta\Strategy\AbstractStrategy;
use Tests\DataFixtures\Annotation\PropertyMappedByStrategyDTO;
use Tests\TestCase\Traits\ReaderTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class NamingStrategyAnnotationsReaderTest
 */
class PropertyStrategiesAnnotationsReaderTest extends TestCase
{
    use ReaderTrait;

    /**
     */
    public function testRelationsAnnotationsParsing(): void
    {
        $reader = $this->createReader(PropertyMappedByStrategyDTO::class);
        $this->assertContainsOnlyInstancesOf(AbstractStrategy::class, $reader->getPropertiesStrategies());
    }
}
