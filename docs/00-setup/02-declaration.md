# Declaration

Every mapped class should be marked by tag and mark by base annotation.  

Annotations used by [`VKMapperBundle\Annotation\MappingMetaReader`](https://github.com/vklymniuk/dto-mapper-bundle/blob/master/src/Annotation/MappingMetaReader.php)  

VKMapperBundle has three base annotation types of class declaration. This annotations used to mark your class as convertible entity with mapped properties.Only marked classes would be configure and stored to cache.

- VKMapperBundle\Annotation\MappingMeta\SourceClass;
- VKMapperBundle\Annotation\MappingMeta\DestinationClass;
- VKMapperBundle\Annotation\MappingMeta\MappedClass;


Use SourceClass and DestinationClass to customize properties naming strategy; [see details](https://github.com/vklymniuk/dto-mapper-bundle/blob/master/docs/01-naming).
Use MappedClass to leave properties naming as is.

Example:
 
```php
<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\MappedClass;

/**
 * @MappedClass
 */
class Any
{
    public $nodeA;
}

/**
 * @SourceClass
 */
class Source
{
    
}

/**
 * @DestinationClass 
 */
class Destination
{
    public $nodeA;
}
```