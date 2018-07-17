
# Base setup

Every mapped class should be marked by tag and @DestinationClass annotation.
Tag used by [`DTOMapperBundle\DependencyInjection\Compiler\MappingCompilePass`](https://github.com/vklymniuk/dto-mapper-bundle/blob/master/src/DependencyInjection/Compiler/MappingCompilePass.php) for relations definition  configure and cache. 

Annotations used by [`DTOMapperBundle\Annotation\MappingMetaReader`](https://github.com/vklymniuk/dto-mapper-bundle/blob/master/src/Annotation/MappingMetaReader.php)
 for source data to object conversion.

```yaml
tags:
    - { name: dto_mapper.destination }
```

Simply add to your class.
```php
<?php

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;

/**
 * Class ClassName
 * @DestinationClass
 */
class ClassName
{
}
```