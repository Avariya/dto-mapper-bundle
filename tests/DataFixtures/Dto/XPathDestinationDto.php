<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

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
