<?php

namespace Tests\TestCase\Mapping\Annotation;

use MapperBundle\Mapping\Annotation\DestinationMetaReader;
use MapperBundle\Mapping\Annotation\Exception\UndeclaredPropertyException;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use Tests\DataFixtures\Dto\RelationsRequestDto;

/**
 * Class DestinationMetaReaderTest
 */
class DestinationMetaReaderTest extends TestCase
{
    /**
     */
    public function testUndefinedClassMapping(): void
    {
        $dto = RelationsRequestDto::class . 'bad';
        $annotationReader = new AnnotationReader();

        $this->expectException(\ReflectionException::class);
        DestinationMetaReader::createReader($annotationReader, $dto);
    }

    /**
     */
    public function testRelationsMetaMapping(): void
    {
        $annotationReader = new AnnotationReader();
        $reader = DestinationMetaReader::createReader($annotationReader, RelationsRequestDto::class);
        $this->assertTrue($reader->hasPropertyRelations());
        $this->assertTrue($reader->hasMultiRelations('registrationsRequests'));
        $this->assertFalse($reader->hasMultiRelations('personalInfo'));
        $this->assertFalse($reader->hasPropertyRelation('extra'));
        $this->expectException(UndeclaredPropertyException::class);
        $this->assertFalse($reader->getPropertyTarget('extra'));
    }
}
