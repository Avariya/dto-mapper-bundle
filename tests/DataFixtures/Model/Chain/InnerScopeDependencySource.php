<?php

namespace Tests\DataFixtures\Model\Chain;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;

/**
 * Class InnerScopeDependencySource
 * @DestinationClass
 */
class InnerScopeDependencySource
{
    /**
     * @return int
     */
    public function getValue(): int
    {
        return 100;
    }
}
