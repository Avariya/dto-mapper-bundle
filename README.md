# Symfony dto-mapper-bundle

[![Build Status](https://travis-ci.org/vklymniuk/dto-mapper-bundle.svg?branch=develop)](https://travis-ci.org/vklymniuk/dto-mapper-bundle)

## Why use DTO MapperBundle?
DTO MapperBundle makes the process of binding all your data mapping rules a lot more easy by providing annotation declarations.
You can extract content from objects and fill objects from raw arrays.
Instead of slow and dummy reflection classes, the bundle uses fast and performance optimized  [code generator](https://github.com/Ocramius/GeneratedHydrator).
All mapping and DI configurations use native symfony cache and lazy loading.

DTO MapperBundle uses customized performance strategies:
 * Converts `Object` to `array`
 * Extracts `Object` to `array`
 * Puts data from `array` into `Object`

## Installation

The suggested installation method's via [composer](https://getcomposer.org/):

```sh
php composer.phar require vklymniuk/dto-mapper-bundle
```
 
## Setup

Tag directory with classes that you want add to mapping.
```yaml
Tests\DataFixtures\Dto\:
resource: '../../DataFixtures/Dto/*'
tags:
    - { name: dto_mapper.destination }
```

Fill in the directory you tagged with annotated classes.
Class example:
 
```php

<?php

namespace Tests\DataFixtures\Dto;

use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class XPathDestinationDto
 * @DestinationClass
 */
class XPathDestinationDto
{
    /**
     * @Strategy\XPathStrategy(
     *     source="Tests\DataFixtures\Model\XPath\RootSourceObject",
     *     xPath="nodeA.inner.optionA"
     * )
     */
    public $value;
}
```

## Usage

Inject MapperInterface into your service.
```php
<?php

use DataMapper\MapperInterface;

class DataTransformer
{
    public function __construct(MapperInterface $mapper);
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

## Documentation
You can learn more about the bundle possibilities and how to use the **DTOMapperBundle** in the [docs](docs).