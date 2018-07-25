<?php

namespace VKMapperBundle\Annotation\MappingMeta;

/**
 * Interface EmbeddedInterface
 */
interface EmbeddedInterface
{
    /**
     * @return string
     */
    public function getTarget(): string;

    /**
     * @return bool
     */
    public function isMulti(): bool;
}
