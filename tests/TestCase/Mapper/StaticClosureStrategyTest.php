<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\StaticClosureDto;
use Tests\DataFixtures\Model\Closure\ClosureProvider;
use Tests\DataFixtures\Model\Closure\ClosureSource;

/**
 * Class StaticClosureStrategyTest
 */
class StaticClosureStrategyTest extends AbstractMapperTest
{
    /**
     */
    public function testStaticClosureStrategyMapping(): void
    {
        $mapper = $this->getMapper();
        $source = new ClosureSource();
        $dto = $mapper->convert($source, StaticClosureDto::class);
        $this->assertContains((string) $source->getSum(), $dto->myValueB);
        $this->assertContains(ClosureProvider::getText(), $dto->myValueB);
    }
}
