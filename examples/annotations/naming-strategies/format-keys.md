```php
<?php

use DataMapper\MapperInterface;
use Tests\DataFixtures\Model\Extractor\UnderscoreInnerObject;
use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\SnakeCaseNamingStrategy;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\UnderscoreNamingStrategy;

/**
 * Class UnderscoreArrayToObjectDto
 * @DestinationClass(namingStrategies={
 *      @SnakeCaseNamingStrategy
 * })
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

or use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\UnderscoreNamingStrategy to 
cast format object props to array keys

```php
<?php
use DataMapper\MapperInterface;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\UnderscoreNamingStrategy;

/**
 * Class ObjectToUnderscoreArrayDto
 * @SourceClass(namingStrategies={
 *     @UnderscoreNamingStrategy
 * })
 */
class ObjectToUnderscoreArrayDto
{
}

/** @var MapperInterface $mapper */
$array = $mapper->extract($source);
```