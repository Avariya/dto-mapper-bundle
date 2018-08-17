<?php

namespace VKMapperBundle\Annotation;

use VKMapperBundle\Annotation\Exception\AnnotationMappingException;
use VKMapperBundle\Annotation\MappingMeta\Strategy;
use VKMapperBundle\Annotation\MappingMeta;

/**
 * Class MappingMetaReader
 */
class MappingMetaReader
{
    /**
     * @var AnnotationReaderInterface
     */
    private $reader;

    /**
     * @var \ReflectionClass
     */
    private $reflectionClass;

    /**
     * @var bool
     */
    private $skip;

    /**
     * @var null|MappingMeta\DestinationClass
     */
    private $source;

    /**
     * @var null|MappingMeta\DestinationClass
     */
    private $destination;

    /**
     * @throws AnnotationMappingException
     *
     * @param AnnotationReaderInterface $reader
     * @param string $className
     *
     * @return MappingMetaReader
     */
    public static function createReader(AnnotationReaderInterface $reader, string $className): self
    {
        return new self($reader, $className);
    }

    /**
     * @throws AnnotationMappingException
     *
     * MappingMetaReader constructor.
     *
     * @param AnnotationReaderInterface $reader
     * @param string $className
     */
    private function __construct(AnnotationReaderInterface $reader, string $className)
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

        $needSkip = null !== $this->reader->getClassAnnotation(
            $this->reflectionClass,
            MappingMeta\MappedClass::class
        );

        if (null !== $destination) {
            $needSkip = false;
            $this->destination = $destination;
        }

        if (null !== $source) {
            $needSkip = false;
            $this->source = $source;
        }

        $this->skip = $needSkip;
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
     *
     * @throws AnnotationMappingException
     */
    public function validate(): void
    {
        if (true === $this->skip()) {
            throw new AnnotationMappingException(
                $this->reflectionClass->getName() .
                ' class - is not registered, please mark your class with one of base annotations: ' .
                '@DestinationClass, @SourceClass, @MappedClass.'
            );
        }
    }
}
