<?php

namespace Tests\DataFixtures\Annotation;

use VK\DTOMapperBundle\Annotation\MappingMeta\DestinationClass;

/**
 * Class EmbeddedCollectionNodeDTO
 * @DestinationClass
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
