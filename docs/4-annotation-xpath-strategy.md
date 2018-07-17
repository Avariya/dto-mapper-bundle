

# @Annotation - XPath Strategy

Recursive value search in inner object properties.

Example:
```php

<?php

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\Strategy;

class InnerObject
{
    private $innerProp = 10;
}

class SourceObject
{
    private $inner;
    
    public function __construct()
    {
        $this->inner = new InnerObject();
    }
}

/**
 * Class XPathDestinationDto
 * @DestinationClass
 */
class XPathDestinationDto
{
    /**
     * @Strategy\XPathStrategy(
     *     source="SourceObject",
     *     xPath="inner.innerProp"
     * )
     */
    public $destinationProperty;
}


use DataMapper\MapperInterface;

/** @var MapperInterface $mapper */
$dto = $mapper->convert(new SourceObject(), XPathDestinationDto::class);

echo $dto->destinationProperty; // 10
```