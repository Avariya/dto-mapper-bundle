```php
<?php

use DataMapper\MapperInterface;
use Tests\DataFixtures\Model\Extractor\UnderscoreInnerObject;
use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;

/**
 * Default naming strategy for array to object convertion for is SnakeCaseNamingStrategy
 * 
 * @DestinationClass()
 */
class UnderscoreArrayToObjectDto
{
    /**
     * @var string
     */
    public $aOption = 'a';

    /**
     * @var string
     */
    public $bOption = 'b';

    /**
     * @EmbeddedClass(target="Tests\DataFixtures\Model\Extractor\UnderscoreInnerObject")
     */
    public $cOption;

    /**
     * ObjectToUnderscoreArray constructor.
     */
    public function __construct()
    {
        $this->cOption = new UnderscoreInnerObject();
    }
}

$source = [
      'a_option' => 111,
      'b_option' => 222,
      'c_option' => [
          'a_option' => 111,
          'b_option' => 222,
      ],
  ];

/** @var MapperInterface $mapper */
$dto = $mapper->convert($source, UnderscoreArrayToObjectDto::class);
```

Default naming strategy for object to array convertion is UnderscoreNamingStrategy

```php
<?php
use DataMapper\MapperInterface;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;

/**
 * Class ObjectToUnderscoreArrayDto
 * @SourceClass()
 */
class ObjectToUnderscoreArrayDto
{
}

/** @var MapperInterface $mapper */
$array = $mapper->extract($source);
```