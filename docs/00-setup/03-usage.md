# Usage

Inject MapperInterface into your service.
```php
<?php

use DataMapper\MapperInterface;

class DataTransformer
{
    public function __construct(MapperInterface $mapper)
}
```

Convert source to dto object:
```php
<?php

use DataMapper\MapperInterface;

/** @var MapperInterface $mapper */
$mapper->convert($source, $destination);
```

Extract content from object into array:
```php
<?php

use DataMapper\MapperInterface;

/** @var MapperInterface $mapper */
$mapper->extract($object);
```