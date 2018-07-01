<?php

namespace MapperBundle;

use MapperBundle\DependencyInjection\Compiler\MappingCompilePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MapperBundle
 */
class MapperBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new MappingCompilePass());
    }
}
