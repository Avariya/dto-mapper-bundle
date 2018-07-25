When you convert source object with mapped properties with EmbeddedClass annotation 
to dto mapper convert source props to target classes and apply all described strategies.  

```php
<?php

use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;
use DataMapper\MapperInterface;

/**
 * Class DtoObjectToObject
 * @SourceClass
 */
class DtoObjectToObject
{
    /**
     * @EmbeddedClass(target="Tests\DataFixtures\Model\Relations\DtoToObjectSourceConvertedProp")
     */
    public $nodeA;

    public function __construct()
    {
        $this->nodeA = new DtoObjectToObjectNodeA();
    }
}

/**
 * Class DtoObjectToObjectNodeA
 * @SourceClass
 */
class DtoObjectToObjectNodeA
{
    /**
     * @Strategy\GetterStrategy(method="getA")
     */
    public $optionA;

    /**
     * @Strategy\GetterStrategy(method="getB")
     */
    public $optionB;

    /**
     * @Strategy\GetterStrategy(method="getC")
     */
    public $optionC;

    /**
     * @return string
     */
    public function getA(): string
    {
        return 'Hello from a!';
    }
    /**
     * @return string
     */
    public function getB(): string
    {
        return 'Hello from b!';
    }
    /**
     * @return string
     */
    public function getC(): string
    {
        return 'Hello from c!';
    }
}

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;

/**
 * Class DtoToObjectSourceProp
 * @DestinationClass
 */
class DtoToObjectSourceConvertedProp
{
    public $optionA;
    public $optionB;
    public $optionC;
}

/** @var MapperInterface $mapper */
$dto = $mapper->convert($source, DtoObjectToObject::class);
$this->assertInstanceOf(DtoToObjectSourceConvertedProp::class, $dto->nodeA);
$this->assertEquals($source->nodeA->getA(), $dto->nodeA->optionA);
$this->assertEquals($source->nodeA->getB(), $dto->nodeA->optionB);
$this->assertEquals($source->nodeA->getC(), $dto->nodeA->optionC);
```