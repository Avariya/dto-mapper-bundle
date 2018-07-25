
# EmbeddedCollection Annotation

Use this annotation to convert array to collection with common objects.
 
Example:

```php
<?php

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedCollection;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;

/**
 * @DestinationClass
 * @SnakeCaseNamingStrategy
 */
class MappedRelationsRootDto
{
    /**
     * @var MappedRelationsNodeInfo
     * @EmbeddedCollection(target="MappedRelationsNodeInfo")
     */
    public $event = [];
}

/**
 * Class MappedRelationsNodeInfo
 */
class MappedRelationsNodeInfo
{
    public $author;
    public $time;
}

$sourceArray = [
   [
       'event' => [
           [
               'author' => 'tester_1',
               'time' => 1234,
           ],
           [
               'author' => 'tester_2',
               'time' => 12345,
           ],
           [
               'author' => 'tester_3',
               'time' => 123456,
           ],
       ],
   ],
];

use DataMapper\MapperInterface;

/** 
 * @var MapperInterface        $mapper 
 * @var MappedRelationsRootDto $dto
 */
$dto = $mapper->convert($sourceArray, MappedRelationsRootDto::class);

```