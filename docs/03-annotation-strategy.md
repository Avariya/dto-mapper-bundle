

# Strategy annotations 

Use strategy declaration to describe how **Mapper** should fetch value from source to mapped property.


Example:
```php

<?php

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class XPathDestinationDto
 * @DestinationClass
 */
class XPathDestinationDto
{
    /**
     * @Strategy\XPathStrategy(
     *     source="FullPath\To\Your\SourceObject",
     *     xPath="variableWithInnerObject.innerObjectPropertyName"
     * )
     */
    public $destinationProperty;
}

```