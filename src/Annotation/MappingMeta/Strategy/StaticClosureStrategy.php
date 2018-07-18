<?php

namespace VK\DTOMapperBundle\Annotation\MappingMeta\Strategy;

use Doctrine\Common\Annotations\Annotation;
use DataMapper\Strategy\ClosureStrategy;

/**
 * @Annotation
 * @Annotation\Target({"PROPERTY", "ANNOTATION"})
 */
class StaticClosureStrategy extends AbstractStrategy implements ChainStrategyInterface
{
    /**
     * @Required
     * @var string
     */
    public $provider;

    /**
     * @Required
     * @var string
     */
    public $method;

    /**
     * @return string
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

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
        return ClosureStrategy::class;
    }
}
