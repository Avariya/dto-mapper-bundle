
# EmbeddedClass Annotation

Use this annotation to convert array to single common object.

 
Example:

```php
<?php

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;

/**
 * @DestinationClass
 * @SnakeCaseNamingStrategy
 */
class MappedRelationsRootDto
{
    /**
     * @var MappedRelationsNodeDto
     * @EmbeddedClass(target="MappedRelationsNodeDto")
     */
    public $nodeA;
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
}

$sourceArray = [
   [
       'node_a' => [
           'property_a'=> 'propertyA',
           'property_b'=> 'propertyB',
           'property_c'=> 'propertyC',
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