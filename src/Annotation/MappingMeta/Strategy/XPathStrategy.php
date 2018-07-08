<?php

namespace DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY", "ANNOTATION"})
 */
class XPathStrategy implements StrategyInterface
{
    /**
     * @Annotation\Required()
     */
    public $sourceClass;

    /**
     * @Annotation\Required()
     */
    public $xPath;

    /**
     * @return string
     */
    public function getSourceClass(): string
    {
        return $this->sourceClass;
    }

    /**
     * @return string
     */
    public function getXPath(): string
    {
        return $this->xPath;
    }
}
