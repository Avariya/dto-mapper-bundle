<?php

namespace Tests\DataFixtures\Dto;

/**
 * Class EmbeddedCollectionNodeDTO
 */
class EmbeddedCollectionNodeDTO
{
    public $nodePropA;
    public $nodePropB;
    public $nodePropC;

    /**
     * @return mixed
     */
    public function getNodePropA()
    {
        return $this->nodePropA;
    }

    /**
     * @return mixed
     */
    public function getNodePropB()
    {
        return $this->nodePropB;
    }

    /**
     * @return mixed
     */
    public function getNodePropC()
    {
        return $this->nodePropC;
    }
}
