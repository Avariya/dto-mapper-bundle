```php
<?php

use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedCollection;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;
use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use DataMapper\MapperInterface;

/**
 * 
 * Class can be used as data provider.
 * SourceClass - can use strategies annotations on property to describe how extract value
 *
 * @SourceClass
 */
class MySourceClass
{
}

/** @var MapperInterface $mapper */
$mapper->convert($mySourceClass, $smth);

/**
 * DestinationClass - implement only @EmbeddedClass or @EmbeddedCollection
 * @DestinationClass
 */
class MyDestinationClass
{
    /**
     * @EmbeddedClass(target="SomeClass")
     */
    public $val;
    
    /**
     * @EmbeddedCollection(target="SomeClass")
     */
    public $setOfValues = [];
}

/** @var MapperInterface $mapper */
$mapper->convert($anything, $myDestinationClass);
```