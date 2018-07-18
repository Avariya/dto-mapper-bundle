<?php

namespace Tests\DataFixtures\Dto;

use VK\DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class XPathDestinationDto
 * @DestinationClass
 */
class XPathDestinationDto
{
    /**
     * @Strategy\XPathStrategy(
     *     source="Tests\DataFixtures\Model\XPath\RootSourceObject",
     *     xPath="nodeA.inner.optionA"
     * )
     */
    public $optionA;

    /**
     * @Strategy\XPathStrategy(
     *     source="Tests\DataFixtures\Model\XPath\RootSourceObject",
     *     xPath="nodeA.inner.optionB"
     * )
     */
    public $optionB;
}
