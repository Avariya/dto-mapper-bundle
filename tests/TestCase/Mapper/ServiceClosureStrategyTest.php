<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\ServiceClosureDto;
use Tests\DataFixtures\Model\Closure\ClosureProvider;
use Tests\DataFixtures\Model\Closure\ClosureSource;
use Tests\DataFixtures\Model\Closure\InnerScopeDependencySource;

/**
 * Class ServiceClosureStrategyTest
 */
class ServiceClosureStrategyTest extends AbstractMapperTest
{
    /**
     */
    public function testStaticClosureStrategyMapping(): void
    {
        $mapper = $this->getMapper();
        $source = new ClosureSource();
        $dto = $mapper->convert($source, ServiceClosureDto::class);
        $providerInnerScopeObject = new InnerScopeDependencySource();

        $this->assertContains((string) ($source->getSum() + $providerInnerScopeObject->getValue()), $dto->myValue);
        $this->assertContains(ClosureProvider::getText(), $dto->myValue);
    }
}
