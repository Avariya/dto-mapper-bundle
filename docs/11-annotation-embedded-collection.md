
# EmbeddedCollection Annotation

Use this annotation to convert array to common object.

 
Example:

```php
<?php

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\EmbeddedCollection;
use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;

/**
 * @DestinationClass
 * @SnakeCaseNamingStrategy
 */
class MappedRelationsRootDto
{
    /**
     * @var MappedRelationsNodeDto
     * @EmbeddedCollection(target="MappedRelationsNodeDto")
     */
    public $nodeA;

    /**
     * @var MappedRelationsNodeInfo
     * @EmbeddedCollection(target="MappedRelationsNodeInfo", multi=true)
     */
    public $event = [];
}

/**
 * Class MappedRelationsNodeDto
 * @DestinationClass
 */
class MappedRelationsNodeDto
{
    public $propertyA;
    public $propertyB;
    public $propertyC;

    /**
     * @var MappedRelationsNodeDto
     * @EmbeddedCollection(target="MappedRelationsNodeDto")
     */
    public $nodeA;
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
       'node_a' => [
           'property_a'=> 'propertyA',
           'property_b'=> 'propertyB',
           'property_c'=> 'propertyC',
           'node_a' => [
               'property_a'=> 'propertyA1',
               'property_b'=> 'propertyB1',
               'property_c'=> 'propertyC1',
               'node_a' => [
                       'property_a'=> 'propertyA1',
                       'property_b'=> 'propertyB1',
                       'property_c'=> 'propertyC1',
               ],
           ],
       ],
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
   ]
];

use DataMapper\MapperInterface;

/** 
 * @var MapperInterface        $mapper 
 * @var MappedRelationsRootDto $dto
 */
$dto = $mapper->convert($sourceArray, MappedRelationsRootDto::class);

```