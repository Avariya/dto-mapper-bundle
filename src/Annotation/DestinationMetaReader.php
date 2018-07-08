<?php

namespace DTOMapperBundle\Annotation;

use Doctrine\Common\Annotations\Reader;
use DTOMapperBundle\Annotation\Exception\DestinationClassException;
use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\EmbeddedCollection;
use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\NamingRegister;
use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\NamingStrategyInterface;
use DTOMapperBundle\Annotation\MappingMeta\Strategy\StrategyInterface;
use DTOMapperBundle\Annotation\MappingMeta\Strategy\StrategyRegister;

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
     * @var \ReflectionClass
     */
    private $reflectionClass;

    /**
     * @var EmbeddedCollection[]
     */
    private $relationsProperties = [];

    /**
     * @var NamingStrategyInterface[]
     */
    private $namingStrategies = [];

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
     * DestinationMetaReader constructor.
     *
     * @param Reader $reader
     * @param string $className
     */
    private function __construct(Reader $reader, string $className)
    {
        $this->reader = $reader;
        $this->reflectionClass = new \ReflectionClass($className);
        $this
            ->loadClassAnnotations()
            ->loadPropertiesAnnotations()
        ;
    }

    /**
     * @throws DestinationClassException
     *
     * @return DestinationMetaReader
     */
    private function loadClassAnnotations(): self
    {
        $isDestination = $this->reader->getClassAnnotation($this->reflectionClass, DestinationClass::class);

        if (!$isDestination) {
            throw new DestinationClassException(
                $this->reflectionClass->getName() . ' - not registered as DestinationClass'
            );
        }
        $this->namingStrategies = $this->getRegisteredNamingStrategies(
            NamingRegister::class,
            NamingStrategyInterface::class
        );

        return $this;
    }

    /**
     * @return DestinationMetaReader
     */
    private function loadPropertiesAnnotations(): self
    {
        $reflectionProperties = $this->reflectionClass->getProperties();
        foreach ($reflectionProperties as $property) {
            $this
                ->processPropertyRelationAnnotation($property);
//                ->processPropertyStrategyAnnotation($property);
        }

        return $this;
    }

    /**
     * @param \ReflectionProperty $property
     *
     * @return DestinationMetaReader
     */
    private function processPropertyRelationAnnotation(\ReflectionProperty $property): self
    {
        $mapperProperty = $this->reader->getPropertyAnnotation($property, EmbeddedCollection::class);

        if ($mapperProperty !== null) {
            $this->relationsProperties[$property->getName()] = $mapperProperty;
        }

        return $this;
    }

    /**
     * @param \ReflectionProperty $property
     *
     * @return DestinationMetaReader
     */
    private function processPropertyStrategyAnnotation(\ReflectionProperty $property): self
    {
        $this->namingStrategies = $this->getRegisteredStrategies(
            StrategyRegister::class,
            StrategyInterface::class
        );
    }

    /**
     * @param string $registerClass
     * @param string $filterClass
     *
     * @return array
     */
    private function getRegisteredNamingStrategies($registerClass, $filterClass): array
    {
        $namingRegister = $this->reader->getClassAnnotation($this->reflectionClass, $registerClass);
        $registered = $namingRegister !== null ? $namingRegister->getFor() : [];

        /** @todo: clean it */
        return array_merge(
            \array_values($registered),
            \array_values(
                \array_filter(
                    $this->reader->getClassAnnotations($this->reflectionClass),
                    function ($annotation) use ($filterClass) {
                        return ($annotation instanceof $filterClass);
                    }
                )
            )
        );
    }
}
