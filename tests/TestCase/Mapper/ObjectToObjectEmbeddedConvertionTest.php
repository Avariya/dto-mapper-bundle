<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\ObjectToObject\ArrayToDto;
use Tests\DataFixtures\Dto\ObjectToObject\DtoNode;
use Tests\DataFixtures\Dto\ObjectToObject\DtoToObject;
use Tests\DataFixtures\Dto\ObjectToObject\ObjectNode;

/**
 * Class ObjectToObjectEmbeddedConvertionTest
 */
class ObjectToObjectEmbeddedConvertionTest extends AbstractMapperTest
{
    /**
     */
    public function testObjectPropertiesConvertion(): void
    {
        $mapper = $this->getMapper();
        $array = [
            'nodeA' => [
                'optionA' => 123,
                'optionB' => 321,
            ]
        ];

        /** @var ArrayToDto $dto */
        $dto = $mapper->convert($array, ArrayToDto::class);
        /** @var DtoToObject $dto2 */
        $dto2 = $mapper->convert($dto, DtoToObject::class);
        $this->assertEquals($dto->nodeA->optionA, $array['nodeA']['optionA']);
        $this->assertEquals($dto->nodeA->optionB, $array['nodeA']['optionB']);
        $this->assertInstanceOf(DtoNode::class, $dto->nodeA);
        $this->assertInstanceOf(ObjectNode::class, $dto2->nodeA);
        $this->assertContains($dto2->nodeA->optionA, $dto->nodeA->getOptionA());
        $this->assertContains($dto2->nodeA->optionB, $dto->nodeA->getOptionB());
    }
}
