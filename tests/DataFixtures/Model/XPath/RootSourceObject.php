<?php

namespace Tests\DataFixtures\Model\XPath;

use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class RootSourceObject
 * @SourceClass
 */
class RootSourceObject
{
    /**
     * @Strategy\XPathStrategy(xPath="nodeA.inner.optionA")
     */
    public $nodeA;

    /**
     * @Strategy\XPathStrategy(xPath="nodeB.inner.optionB")
     */
    public $nodeB;

    /**
     * RootSourceObject constructor.
     */
    public function __construct()
    {
        $this->nodeA = new NodeAObject();
        $this->nodeB = new NodeAObject();
    }
}
