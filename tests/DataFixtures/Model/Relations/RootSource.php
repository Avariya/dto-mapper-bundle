<?php

namespace Tests\DataFixtures\Model\Relations;

/**
 * Class RootSource
 */
class RootSource
{
    /**
     * @var MappedRelationsNodeInfo
     */
    public $nodeA;

    /**
     * @var MappedRelationsNodeInfo
     */
    public $nodeB;

    /**
     * RootSource constructor.
     */
    public function __construct()
    {
        $this->nodeA = new MappedRelationsNodeInfo();
        $this->nodeB = new MappedRelationsNodeInfo();
    }
}
