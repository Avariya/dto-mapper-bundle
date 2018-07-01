<?php

namespace DataMapperBundle\Annotation;

use Doctrine\Common\Annotations\Reader;
use MapperBundle\Mapping\Annotation\Exception\UndeclaredPropertyException;
use MapperBundle\Mapping\Annotation\Meta\DestinationClass;


/**
 * Class DestinationMetaReader
 */
class DestinationMetaReader
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     */
    private $relationsProperties = [];

    /**
     * @param Reader $reader
     * @param string $className
     *
     * @return DestinationMetaReader
     */
    public static function createReader(Reader $reader, string $className): self
    {
        return new self($reader, $className);
    }

    /**
     * {@inheritDoc}
     */
    public function hasPropertyRelations(): bool
    {
        return (bool) \count($this->relationsProperties);
    }

    /**
     * {@inheritDoc}
     */
    public function hasMultiRelations(string $propertyName): bool
    {
        return !$this->hasPropertyRelation($propertyName) ?:
            $this->loadPropertyRelation($propertyName)->isMultiply();
    }

    /**
     * {@inheritDoc}
     */
    public function hasPropertyRelation(string $propertyName): bool
    {
        return isset($this->relationsProperties[$propertyName]);
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyTarget(string $propertyName): string
    {
        return $this->loadPropertyRelation($propertyName)->getTargetClass();
    }

    /**
     * DestinationMetaReader constructor.
     *
     * @param Reader $reader
     * @param string $className
     */
    private function __construct(Reader $reader, string $className)
    {
        $this->reader = $reader;
        $reflectionClass = new \ReflectionClass($className);
        $this
            ->loadClassAnnotations($reflectionClass);

//        $reflectionProperties = $reflectionClass->getProperties();
//
//        foreach ($reflectionProperties as $property) {
//            /** @var PropertyClassRelation $mapperProperty */
//            if (!$mapperProperty = $reader->getPropertyAnnotation($property, PropertyClassRelation::class)) {
//                continue;
//            }
//
//            $this->relationsProperties[$property->getName()] = $mapperProperty;
//        }
    }

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return DestinationMetaReader
     */
    private function loadClassAnnotations(\ReflectionClass $reflectionClass): self
    {
        $hasDestinationMapping = (bool) $this->reader->getClassAnnotation($reflectionClass, DestinationClass::class);

    }

    private function loadPropertyAnnotations()
    {

    }

    /**
     * @throws UndeclaredPropertyException
     *
     * @param string $propertyName
     *
     * @return PropertyClassRelation
     */
    private function loadPropertyRelation(string $propertyName): PropertyClassRelation
    {
        if (isset($this->relationsProperties[$propertyName]) === false) {
            throw new UndeclaredPropertyException('Property: ' . $propertyName . ' has no target binding');
        }

        return $this->relationsProperties[$propertyName];
    }
}
