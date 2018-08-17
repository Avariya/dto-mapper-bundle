```php
<?php

use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\Map;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\MapNamingStrategy;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;
use DataMapper\MapperInterface;

/**
 * Class RenameCustomerPropsSource
 *
 * @SourceClass(namingStrategies={
 *     @MapNamingStrategy(
 *      convert={
 *          @Map(from="propAA", to="fistName"),
 *          @Map(from="propBB", to="lastName"),
 *          @Map(from="propCC", to="department"),
 *          @Map(from="propDD", to="birthday")
 *     })
 * })
 */
class RenameCustomerPropsSource
{
    public $propAA = 'Ivan';
    public $propBB = 'Ivanov';
    public $propCC = 'Retail';

    /**
     * @Strategy\GetterStrategy(method="getBirthday")
     */
    public $propDD;

    /**
     * @return string
     */
    public function getBirthday(): string
    {
        return '2018-18-18';
    }
}

/**
 * Class CustomerInfoDto
 * @DestinationClass
 */
class CustomerInfoDto
{
    public $fistName;
    public $lastName;
    public $department;
    public $birthday;
}

/** @var MapperInterface $mapper */
$mapper = $this->getMapper();
$source = new RenameCustomerPropsSource();
/** @var CustomerInfoDto $dto */
$dto = $mapper->convert($source, CustomerInfoDto::class);
$this->assertEquals($source->getBirthday(), $dto->birthday);
$this->assertEquals($source->propAA, $dto->fistName);
$this->assertEquals($source->propBB, $dto->lastName);
$this->assertEquals($source->propCC, $dto->department);

```
```php

<?php

namespace Tests\DataFixtures\Dto;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\Map;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\MapNamingStrategy;
use DataMapper\MapperInterface;

/**
 * Class RenamePropsDto
 * @DestinationClass(namingStrategies={
 *     @MapNamingStrategy(
 *      convert={
 *          @Map(from="some_A", to="propA"),
 *          @Map(from="some_B", to="propB"),
 *          @Map(from="some_C", to="propC")
 *     }
 *  )
 * })
 */
class RenamePropsDto
{
    public $propA = 1;
    public $propB = 2;
    public $propC = 3;
}

/** @var MapperInterface $mapper */
$mapper = $this->getMapper();
$source = [
    'some_A' => 111,
    'some_B' => 222,
    'some_C' => 333,
];
$dto = $mapper->convert($source, RenamePropsDto::class);
$this->assertEquals($dto->propA, $source['some_A']);
$this->assertEquals($dto->propB, $source['some_B']);
$this->assertEquals($dto->propC, $source['some_C']);
```

[back](..)