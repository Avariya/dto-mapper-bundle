<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\DtoObjectToObject;
use Tests\DataFixtures\Model\Relations\DtoToObjectSourceConvertedProp;

/**
 * Class ObjectToObjectEmbeddedConvertionTest
 */
class ObjectToObjectEmbeddedConvertionTest extends AbstractMapperTest
{
    /**
     */
    public function testObjectPropertiesConvertion(): void
    {
        $source =  new DtoObjectToObject();
        $mapper = $this->getMapper();
        $dto = $mapper->convert($source, DtoObjectToObject::class);
        $this->assertInstanceOf(DtoToObjectSourceConvertedProp::class, $dto->nodeA);
        $this->assertEquals($source->nodeA->getA(), $dto->nodeA->optionA);
        $this->assertEquals($source->nodeA->getB(), $dto->nodeA->optionB);
        $this->assertEquals($source->nodeA->getC(), $dto->nodeA->optionC);
    }
}
