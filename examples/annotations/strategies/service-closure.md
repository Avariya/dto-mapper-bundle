# @Annotation - Service Closure Strategy

Strategy extracts closure from service method and executes it with source value in 
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

class ClosureServiceProvider
{
    private $multiplier = 5;

    public function calculate(): \Closure
    {
        return function (ClosureSource $source) {
            return ($source->getX() * $source->getY()) * $this->multiplier; 
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
echo $dto->result; // 125

```