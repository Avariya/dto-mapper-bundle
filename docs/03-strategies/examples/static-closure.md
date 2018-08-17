# @Annotation - Service Static Closure Strategy

Strategy extracts closure from service static method and executes it with source value in 
service provider context.

Example:
```php
<?php

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * @SourceClass 
 */
class ClosureSource
{
    /**
     * @Strategy\StaticClosureStrategy(
     *     provider="ClosureServiceProvider",
     *     method="calculate"
     * )
     */
    public $result;

    public function getX(): int
    {
        return 5;
    }
    
    public function getY(): int
    {
        return 5;
    }
}

class ClosureProvider
{
    public static function calculate(): \Closure
    {
        return function (ClosureSource $source) {
            return $source->getX() * $source->getY(); 
        };
    }
}

/**
 * Class ResultDto
 * @DestinationClass
 */
class ResultDto
{
    public $result;
}

use DataMapper\MapperInterface;

/** @var MapperInterface $mapper */
$dto = $mapper->convert(new ClosureSource(), ResultDto::class);

```

[back](..)