<?php

namespace VKMapperBundle\Annotation\MappingMeta\Strategy;

use DataMapper\Strategy\FormatterStrategy;
use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY", "ANNOTATION"})
 */
class PropertyFormatterStrategy extends AbstractStrategy implements ChainStrategyInterface
{
    /**
     * @Required
     * @var string
     */
    public $method;

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getStrategyClassName(): string
    {
        return FormatterStrategy::class;
    }
}
