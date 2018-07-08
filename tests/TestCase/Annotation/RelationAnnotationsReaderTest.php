<?php

namespace Tests\TestCase\Annotation;

use PHPUnit\Framework\TestCase;
use Tests\DataFixtures\Annotation\EmbeddedCollectionRootDTO;
use Tests\DataFixtures\Annotation\EmbeddedCollectionNodeDTO;
use Tests\TestCase\Traits\ReaderTrait;

/**
 * Class RelationAnnotationsReaderTest
 */
class RelationAnnotationsReaderTest extends TestCase
{
    use ReaderTrait;

    /**
     *
     */
    public function testRelationsAnnotationsParsing(): void
    {
        $reader = $this->createReader(EmbeddedCollectionRootDTO::class);
        $singleKey = 'singleNode';
        $multiNode = 'multiNode';
        $targetClass = EmbeddedCollectionNodeDTO::class;

        $props = $reader->getRelationsProperties();
        $this->assertArrayHasKey($singleKey, $props);
        $this->assertArrayHasKey($multiNode, $props);
        $this->assertFalse($props[$singleKey]->isMulti());
        $this->assertTrue($props[$multiNode]->isMulti());
        $this->assertEquals($props[$singleKey]->getTarget(), $targetClass);
        $this->assertEquals($props[$multiNode]->getTarget(), $targetClass);
    }
}
