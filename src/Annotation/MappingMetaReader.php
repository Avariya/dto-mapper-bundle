<?php

namespace DTOMapperBundle\Annotation;

use DTOMapperBundle\Annotation\Exception\DestinationClassException;
use DTOMapperBundle\Annotation\MappingMeta\DestinationClass;
use DTOMapperBundle\Annotation\MappingMeta\EmbeddedCollection;
use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\NamingRegister;
use DTOMapperBundle\Annotation\MappingMeta\NamingStrategy\NamingStrategyInterface;
use DTOMapperBundle\Annotation\MappingMeta\Strategy\StrategyInterface;
use DTOMapperBundle\Annotation\MappingMeta\Strategy\StrategyRegister;

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
     * @var EmbeddedCollection[]
     */
    private $relationsProperties = [];

    /**
     * @var NamingStrategyInterface[]
     */
    private $namingStrategies = [];

    /**
     * @var StrategyInterface[]
     */
    private $propertiesStrategies = [];

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
     * @return EmbeddedCollection[]
     */
    public function getRelationsProperties(): array
    {
        return $this->relationsProperties;
    }

    /**
     * @return NamingStrategyInterface[]
     */
    public function getNamingStrategies(): array
    {
        return $this->namingStrategies;
    }

    /**
     * @return StrategyInterface[]
     */
    public function getPropertiesStrategies(): array
    {
        return $this->propertiesStrategies;
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
        $reflectionClass = new \ReflectionClass($className);
        $isDestination = $this->reader->getClassAnnotation($reflectionClass, DestinationClass::class);

        if (!$isDestination) {
            throw new DestinationClassException(
                $reflectionClass->getName() . ' - is not registered as DestinationClass.'
            );
        }

        $this
            ->loadClassAnnotations($reflectionClass)
            ->loadPropertiesAnnotations($reflectionClass);
    }

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return MappingMetaReader
     */
    private function loadClassAnnotations(\ReflectionClass $reflectionClass): self
    {
        $namingRegister = $this->reader->getClassAnnotation($reflectionClass, NamingRegister::class);
        $registered = $namingRegister !== null ? $namingRegister->getFor() : [];
        $filteredNaming = \array_filter(
            $this->reader->getClassAnnotations($reflectionClass),
            function ($annotation): bool {
                return \is_a($annotation, NamingStrategyInterface::class);
            }
        );

        $this->namingStrategies = array_merge(
            \array_values($registered),
            \array_values($filteredNaming)
        );

        return $this;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return MappingMetaReader
     */
    private function loadPropertiesAnnotations(\ReflectionClass $reflectionClass): self
    {
        $reflectionProperties = $reflectionClass->getProperties();

        foreach ($reflectionProperties as $property) {
            $this
                ->processPropertyRelationAnnotation($property)
                ->processPropertyStrategyAnnotation($property);
        }

        return $this;
    }

    /**
     * @param \ReflectionProperty $property
     *
     * @return MappingMetaReader
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
     * @return MappingMetaReader
     */
    private function processPropertyStrategyAnnotation(\ReflectionProperty $property): self
    {
        $filtered = \array_filter(
            $this->reader->getPropertyAnnotations($property),
            function ($annotation): bool {
                return \is_a($annotation, StrategyInterface::class);
            }
        );

        $registered = $this->reader->getPropertyAnnotation($property, StrategyRegister::class);
        $registered = $registered !== null ? $registered->getFor() : [];
        $this->propertiesStrategies[$property->getName()] = \array_merge(
            \array_values($filtered),
            \array_values($registered)
        );

        return $this;
    }
}
