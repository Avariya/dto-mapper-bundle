
# @Annotation - Strategy Static Closure 

Strategy extracts closure function from declared static method and executes it with source value.

Example:
```php
<?php

use VK\DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use VK\DTOMapperBundle\Annotation\MappingMeta\Strategy;

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
    /**
     * @Strategy\StaticClosureStrategy(
     *     source="ClosureSource",
     *     provider="ClosureProvider",
     *     method="calculate"
     * )
     */
    public $result;
}

use DataMapper\MapperInterface;

/** @var MapperInterface $mapper */
$dto = $mapper->convert(new ClosureSource(), ResultDto::class);
echo $dto->result; // 25

```