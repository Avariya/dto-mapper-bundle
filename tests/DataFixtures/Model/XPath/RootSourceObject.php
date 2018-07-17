<?php

namespace Tests\DataFixtures\Model\XPath;

/**
 * Class RootSourceObject
 */
class RootSourceObject
{
    /**
     * @var NodeAObject
     */
    public $nodeA;

    /**
     * RootSourceObject constructor.
     */
    public function __construct()
    {
        $this->nodeA = new NodeAObject();
    }
}
