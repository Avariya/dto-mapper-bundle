<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\ObjectToObjectDto;
use Tests\DataFixtures\Model\Relations\RootSource;

/**
 * Class ObjectToClassMappingTest
 */
class ObjectToClassMappingTest extends AbstractMapperTest
{
    /**
     */
    public function testObjectToClassMapping(): void
    {
        $source = new RootSource();
        /** @var ObjectToObjectDto $dto */
        $dto = $this->getMapper()->convert($source, ObjectToObjectDto::class);
        $this->assertAttributeEquals($source->nodeA, 'nodeA', $dto);
        $this->assertAttributeEquals($source->getMe(), 'testMe', $dto);
        $this->assertAttributeEquals($source->getMe(), 'nodeB', $dto);
    }

    /**
     */
    public function testObjectToObjectMapping(): void
    {
        $source = new RootSource();
        $dto = new ObjectToObjectDto();
        /** @var ObjectToObjectDto $dto */
        $dto = $this->getMapper()->convert($source, $dto);

        $this->assertAttributeEquals($source->nodeA, 'nodeA', $dto);
        $this->assertAttributeEquals($source->getMe(), 'nodeB', $dto);
    }
}
