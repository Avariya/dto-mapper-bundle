<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\GetterDestinationDto;
use Tests\DataFixtures\Model\Getter\SourceObject;

/**
 * Class FormatterStrategyTest
 */
class FormatterStrategyTest extends AbstractMapperTest
{
    /**
     */
    public function testObjectPropertyFormatter(): void
    {
        $mapper = $this->getMapper();
        $source = new SourceObject();
        /** @var GetterDestinationDto $dto */
        $dto = $mapper->convert($source, GetterDestinationDto::class);
        $this->assertEquals($source->getSum(), $dto->sum);
    }
}
