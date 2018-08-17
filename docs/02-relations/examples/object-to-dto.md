When you convert source object with mapped properties with EmbeddedClass annotation 
to dto mapper convert source props to target classes and apply all described strategies.  

```php
<?php

use VKMapperBundle\Annotation\MappingMeta\EmbeddedClass;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;
use DataMapper\MapperInterface;

/**
 * Class DtoObjectToObject
 * @DestinationClass
 */
class ArrayToDto
{
    /**
     * @var DtoNode
     * @EmbeddedClass(target="Tests\DataFixtures\Dto\ObjectToObject\DtoNode")
     */
    public $nodeA;
}

/**
 * Class DtoNode
 * @SourceClass
 */
class DtoNode
{
    /**
     * @Strategy\GetterStrategy(method="getOptionA")
     */
    public $optionA = 1;

    /**
     * @Strategy\GetterStrategy(method="getOptionB")
     */
    public $optionB = 2;

    /**
     * @return string
     */
    public function getOptionA(): string
    {
        return 'Hello ' . $this->optionA .' A!';
    }

    /**
     * @return string
     */
    public function getOptionB(): string
    {
        return 'Hello ' . $this->optionB .' B!';
    }
}


/**
 * Class DtoObjectToObjectNodeA
 * @DestinationClass
 */
class DtoToObject
{
    /**
     * @var ObjectNode
     * @EmbeddedClass(target="Tests\DataFixtures\Dto\ObjectToObject\ObjectNode")
     */
    public $nodeA;
}

/**
 * Class ObjectNode
 * @DestinationClass
 */
class ObjectNode
{
    public $optionA;
    public $optionB;
}


$array = [
    'nodeA' => [
        'optionA' => 123,
        'optionB' => 321,
    ]
];

/** @var MapperInterface $mapper */
/** @var ArrayToDto $dto */
$dto = $mapper->convert($array, ArrayToDto::class);
/** @var DtoToObject $dto2 */
$dto2 = $mapper->convert($dto, DtoToObject::class);
$this->assertEquals($dto->nodeA->optionA, $array['nodeA']['optionA']);
$this->assertEquals($dto->nodeA->optionB, $array['nodeA']['optionB']);
$this->assertInstanceOf(DtoNode::class, $dto->nodeA);
$this->assertInstanceOf(ObjectNode::class, $dto2->nodeA);
$this->assertContains($dto2->nodeA->optionA, $dto->nodeA->getOptionA());
$this->assertContains($dto2->nodeA->optionB, $dto->nodeA->getOptionB());
```