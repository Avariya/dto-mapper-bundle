<?php

namespace VKMapperBundle\Annotation;

use VKMapperBundle\Annotation\Exception\DestinationClassException;
use VKMapperBundle\Annotation\MappingMeta\Strategy;
use VKMapperBundle\Annotation\MappingMeta;

use Doctrine\Common\Annotations\Reader;

/**
 * Class MappingMetaReader
 */
class MappingMetaReader
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var \ReflectionClass
     */
    private $reflectionClass;

    /**
     * @var bool
     */
    private $skip = true;

    /**
     * @var null|MappingMeta\DestinationClass
     */
    private $source;

    /**
     * @var null|MappingMeta\DestinationClass
     */
    private $destination;

    /**
     * @throws DestinationClassException
     *
     * @param Reader $reader
     * @param string $className
     *
     * @return MappingMetaReader
     */
    public static function createReader(Reader $reader, string $className): self
    {
        return new self($reader, $className);
    }

    /**
     * @throws DestinationClassException
     *
     * MappingMetaReader constructor.
     *
     * @param Reader $reader
     * @param string $className
     */
    private function __construct(Reader $reader, string $className)
    {
        $this->reader = $reader;
        $this->reflectionClass = new \ReflectionClass($className);
        $destination = $this->reader->getClassAnnotation(
            $this->reflectionClass,
            MappingMeta\DestinationClass::class
        );
        $source = $this->reader->getClassAnnotation(
            $this->reflectionClass,
            MappingMeta\SourceClass::class
        );

        if (null !== $destination) {
            $this->skip = false;
            $this->destination = $destination;
        }

        if (null !== $source) {
            $this->skip = false;
            $this->source = $source;
        }
    }

    /**
     * @return iterable
     */
    public function getSourceNamingStrategies(): iterable
    {
        $this->validate();
        if (false === $this->isSource() || null === $this->source->getNamingStrategies()) {
            return;
        }

        foreach ($this->source->getNamingStrategies() as $annotation) {
            yield $annotation;
        }
    }

    /**
     * @return iterable
     */
    public function getDestinationNamingStrategies(): iterable
    {
        $this->validate();
        if (false === $this->isDestination() || null === $this->destination->getNamingStrategies()) {
            return;
        }

        foreach ($this->destination->getNamingStrategies() as $annotation) {
            yield $annotation;
        }
    }

    /**
     * @return iterable
     */
    public function getRelationsProperties(): iterable
    {
        $this->validate();

        foreach ($this->reflectionClass->getProperties() as $property) {
            $annotation = $this
                ->reader
                ->getPropertyAnnotation(
                    $property,
                    MappingMeta\EmbeddedClass::class
                );

            if (null !== $annotation) {
                yield $property->getName() => $annotation;
            }

            $annotation = $this
                ->reader
                ->getPropertyAnnotation(
                    $property,
                    MappingMeta\EmbeddedCollection::class
                );

            if (null !== $annotation) {
                yield $property->getName() => $annotation;
            }
        }
    }

    /**
     * @return iterable
     */
    public function getPropertiesStrategies(): iterable
    {
        $this->validate();
        $reflectionProperties = $this->reflectionClass->getProperties();

        foreach ($reflectionProperties as $property) {
            foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                if (true === \is_a($annotation, Strategy\StrategyInterface::class)) {
                    yield $property->getName() => $annotation;
                }
            }
        }
    }

    /**
     * @return bool
     */
    public function isSource(): bool
    {
        return null !== $this->source;
    }

    /**
     * @return bool
     */
    public function isDestination(): bool
    {
        return null !== $this->destination;
    }

    /**
     * @return bool
     */
    public function skip(): bool
    {
        return $this->skip;
    }

    /**
     * Is class mapped
     * @throws DestinationClassException
     */
    public function validate(): void
    {
        if (true === $this->skip()) {
            throw new DestinationClassException(
                $this->reflectionClass->getName() .
                ' class - is not registered, please use DestinationClass or SourceClass annotations on class.'
            );
        }
    }
}
