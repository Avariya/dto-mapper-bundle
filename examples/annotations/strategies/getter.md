

# @Annotation - Getter Strategy

Strategy calls the "getter|formatter" method from source object for extraction property value.

Example:
```php

<?php 

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;

/**
 * Class DestinationDto
 * @SourceClass
 */
class SourceObject
{
    /**
     * @Strategy\GetterStrategy(method="getSum")
     */
    public $sum;

    private $variableA = 10;
    private $variableB = 10;

    public function getSum(): int
    {
        return $this->variableA + $this->variableB;
    }
}

/**
 * Class DestinationDto
 * @DestinationClass
 */
class GetterDestinationDto
{
    public $sum;
}

use DataMapper\MapperInterface;

/** @var MapperInterface $mapper */
$dto = $mapper->convert(new SourceObject(), GetterDestinationDto::class);

echo $dto->sum; // 20

```