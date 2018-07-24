<?php

namespace VKMapperBundle\Annotation;

use VKMapperBundle\Annotation\Exception\DestinationClassException;
use VKMapperBundle\Annotation\MappingMeta\{DestinationClass, EmbeddedClass, EmbeddedCollection, SourceClass};
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\{NamingRegister,NamingStrategyInterface};
use VKMapperBundle\Annotation\MappingMeta\Strategy\{StrategyInterface, StrategyRegister};

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
     * @var bool
     */
    private $isSource = false;

    /**
     * @var bool
     */
    private $isDestination = false;

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
        $isDestination = $this->reader->getClassAnnotation($this->reflectionClass, DestinationClass::class);
        $iSource = $this->reader->getClassAnnotation($this->reflectionClass, SourceClass::class);

        if (null !== $isDestination) {
            $this->skip = false;
            $this->isDestination = true;
        }

        if (null !== $iSource) {
            $this->skip = false;
            $this->isSource = true;
        }
    }

    /**
     * @return \Generator
     */
    public function getNamingStrategies(): \Generator
    {
        $this->validate();
        $namingRegister = $this->reader->getClassAnnotation($this->reflectionClass, NamingRegister::class);
        $registered = $namingRegister !== null ? $namingRegister->getFor() : [];
        $filteredNaming = \array_filter(
            $this->reader->getClassAnnotations($this->reflectionClass),
            function ($annotation): bool {
                return \is_a($annotation, NamingStrategyInterface::class);
            }
        );

        foreach (\array_merge(\array_values($registered), \array_values($filteredNaming)) as $namingStrategy) {
            yield $namingStrategy;
        }
    }

    /**
     * @return \Generator
     */
    public function getRelationsProperties(): \Generator
    {
        $this->validate();
        $reflectionProperties = $this->reflectionClass->getProperties();

        foreach ($reflectionProperties as $property) {
            foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                if (!($annotation instanceof EmbeddedCollection) && !($annotation instanceof EmbeddedClass)) {
                    continue;
                }

                yield $property->getName() => $annotation;
            }
        }
    }

    /**
     * @return \Generator
     */
    public function getPropertiesStrategies(): \Generator
    {
        $this->validate();
        $reflectionProperties = $this->reflectionClass->getProperties();

        foreach ($reflectionProperties as $property) {
            $filtered = \array_filter(
                $this->reader->getPropertyAnnotations($property),
                function ($annotation): bool {
                    return \is_a($annotation, StrategyInterface::class);
                }
            );

            $registered = $this->reader->getPropertyAnnotation($property, StrategyRegister::class);
            $registered = $registered !== null ? $registered->getFor() : [];

            if (!\count($registered) && !\count($filtered)) {
                continue;
            }

            foreach (\array_merge(\array_values($filtered), \array_values($registered)) as $propertyStrategy) {
                yield $property->getName() => $propertyStrategy;
            }
        }
    }

    /**
     * @return bool
     */
    public function isSource(): bool
    {
        return $this->isSource;
    }

    /**
     * @return bool
     */
    public function isDestination(): bool
    {
        return $this->isDestination;
    }

    /**
     * @return bool
     */
    public function skip(): bool
    {
        return $this->skip;
    }

    /**
     * can read
     */
    public function validate(): void
    {
        if (true === $this->skip()) {
            throw new DestinationClassException(
                $this->reflectionClass->getName() .
                ' - is not registered, please use DestinationClass or SourceClass annotations on class.'
            );
        }
    }
}
