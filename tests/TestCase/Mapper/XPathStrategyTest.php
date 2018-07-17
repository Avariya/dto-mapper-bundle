<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\XPathDestinationDto;
use Tests\DataFixtures\Model\XPath\RootSourceObject;

/**
 * Class XPathStrategyTest
 */
class XPathStrategyTest extends AbstractMapperTest
{
    /**
     */
    public function testXPathMapperStrategy(): void
    {
        $source = new RootSourceObject();
        $mapper = $this->getMapper();
        /** @var XPathDestinationDto $dto */
        $dto = $mapper->convert($source, XPathDestinationDto::class);
        $this->assertEquals($dto->optionA, $source->nodeA->inner->optionA);
        $this->assertEquals($dto->optionB, $source->nodeA->inner->optionB);
    }
}
