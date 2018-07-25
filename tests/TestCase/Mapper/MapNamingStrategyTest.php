<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\RenamePropsDto;
use Tests\DataFixtures\Model\Rename\CustomerInfoDto;
use Tests\DataFixtures\Model\Rename\RenameCustomerPropsSource;

/**
 * Class MapNamingStrategyTest
 */
class MapNamingStrategyTest extends AbstractMapperTest
{
    /**
     */
    public function testArrayToDtoRenameKeys(): void
    {
        $mapper = $this->getMapper();
        $source = [
            'some_A' => 111,
            'some_B' => 222,
            'some_C' => 333,
        ];
        $dto = $mapper->convert($source, RenamePropsDto::class);
        $this->assertEquals($dto->propA, $source['some_A']);
        $this->assertEquals($dto->propB, $source['some_B']);
        $this->assertEquals($dto->propC, $source['some_C']);
    }

    /**
     */
    public function testObjectToDtoRenameKeys(): void
    {
        $mapper = $this->getMapper();
        $source = new RenameCustomerPropsSource();
        $dto = $mapper->convert($source, CustomerInfoDto::class);
        $this->assertEquals($source->getBirthday(), $dto->birthday);
        $this->assertEquals($source->propAA, $dto->fistName);
        $this->assertEquals($source->propBB, $dto->lastName);
        $this->assertEquals($source->propCC, $dto->department);
    }
}
