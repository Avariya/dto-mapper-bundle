<?php

namespace VKMapperBundle\Annotation;

use Doctrine\Common\Annotations\Reader;

/**
 * Class AnnotationReader
 */
class AnnotationReader implements AnnotationReaderInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * AnnotationReader constructor.
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassAnnotations(\ReflectionClass $class): array
    {
        return $this->reader->getClassAnnotations($class);
    }

    /**
     * {@inheritDoc}
     */
    public function getClassAnnotation(\ReflectionClass $class, string $annotationName): ?object
    {
        return $this->reader->getClassAnnotation($class, $annotationName);
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotations(\ReflectionMethod $method): array
    {
        return $this->reader->getMethodAnnotations($method);
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotation(\ReflectionMethod $method, string $annotationName): ?object
    {
        return $this->reader->getMethodAnnotation($method, $annotationName);
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotations(\ReflectionProperty $property): array
    {
        return $this->reader->getPropertyAnnotations($property);
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotation(\ReflectionProperty $property, string $annotationName): ?object
    {
        return $this->reader->getPropertyAnnotation($property, $annotationName);
    }
}
