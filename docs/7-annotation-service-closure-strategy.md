
# @Annotation - Service Closure Strategy

Strategy extracts closure from service method and executes it with source value in 
service provider context.

Example:
```php
<?php

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\Strategy;

class ClosureSource
{
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
    /**
     * @Strategy\StaticClosureStrategy(
     *     source="ClosureSource",
     *     provider="ClosureServiceProvider",
     *     method="calculate"
     * )
     */
    public $result;
}

use DataMapper\MapperInterface;

/** @var MapperInterface $mapper */
$dto = $mapper->convert(new ClosureSource(), ResultDto::class);
echo $dto->result; // 125

```