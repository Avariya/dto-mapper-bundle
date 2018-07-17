<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\GetterDestinationDto;
use Tests\DataFixtures\Model\Getter\SourceObject;

/**
 * Class GettersStrategyTest
 */
class GettersStrategyTest extends AbstractMapperTest
{
    /**
     */
    public function testObjectToClassMapping(): void
    {
        $mapper = $this->getMapper();
        $source = new SourceObject();
        /** @var GetterDestinationDto $dto */
        $dto = $mapper->convert($source, GetterDestinationDto::class);
        $this->assertEquals($source->getSum(), $dto->sum);
    }

    /**
     */
    public function testObjectToObjectMapping(): void
    {
        $mapper = $this->getMapper();
        $source = new SourceObject();
        $dto = new GetterDestinationDto();
        $innerValue = $dto->innerValue;

        /** @var GetterDestinationDto $dto */
        $dto = $mapper->convert($source, $dto);
        $this->assertEquals($source->getSum(), $dto->sum);
        $this->assertEquals($innerValue, $dto->innerValue);
    }
}
