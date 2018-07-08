<?php

namespace DTOMapperBundle;

use DTOMapperBundle\DependencyInjection\Compiler\MappingCompilePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DTOMapperBundle
 */
class DTOMapperBundle extends Bundle
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
