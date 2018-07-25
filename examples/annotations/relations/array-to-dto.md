```php
<?php

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedCollection;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;
use DataMapper\MapperInterface;

/**
 * Class MappedRelationsRootDto
 *
 * @DestinationClass(namingStrategies={
 *    @SnakeCaseNamingStrategy
 * })
 */
class MappedRelationsRootDto
{
    /**
     * @EmbeddedClass(target="Tests\DataFixtures\Dto\MappedRelationsNodeDto")
     */
    public $nodeA;

    /**
     * @EmbeddedClass(target="Tests\DataFixtures\Dto\MappedRelationsNodeDto")
     */
    public $nodeB;

    /**
     * @EmbeddedCollection(target="Tests\DataFixtures\Model\Relations\MappedRelationsNodeInfo")
     */
    public $event = [];
}

/** @var MapperInterface $mapper */
$mapper->convert($array, $mappedRelationsRootDto);

```