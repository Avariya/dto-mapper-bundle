<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\ChainDestinationDto;
use Tests\DataFixtures\Model\Chain\ChainSource;
use Tests\DataFixtures\Model\Chain\InnerScopeDependencySource;

/**
 * Class ChainStrategyTest
 */
class ChainStrategyTest extends AbstractMapperTest
{
    /**
     */
    public function testChainStrategyMapping(): void
    {
        $source = new ChainSource();
        $valueProvider = new InnerScopeDependencySource();
        $expectedValue = ($source->baseValue * 2 * $valueProvider->getValue() * $valueProvider->getValue());

        /** @var ChainDestinationDto $dto */
        $dto = $this->getMapper()->convert($source, ChainDestinationDto::class);
        $this->assertEquals($dto->chainMappedProperty, $expectedValue);
    }
}
