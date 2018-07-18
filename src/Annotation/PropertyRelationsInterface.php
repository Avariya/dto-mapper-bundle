<?php

namespace VK\DTOMapperBundle\Mapping\Annotation;

use VK\DTOMapperBundle\Annotation\Exception\UndeclaredPropertyException;

/**
 * Interface PropertyRelationsInterface
 */
interface PropertyRelationsInterface
{
    /**
     * @return bool
     */
    public function hasPropertyRelations(): bool;

    /**
     * @param string $propertyName
     *
     * @return bool
     */
    public function hasMultiRelations(string $propertyName): bool;

    /**
     * @param string $propertyName
     *
     * @return bool
     */
    public function hasPropertyRelation(string $propertyName): bool;

    /**
     * @throws UndeclaredPropertyException
     *
     * @param string $propertyName
     *
     * @return string
     */
    public function getPropertyTarget(string $propertyName): string;
}
