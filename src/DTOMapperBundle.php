<?php

namespace VKMapperBundle;

use VKMapperBundle\DependencyInjection\Compiler\MappingCompilePass;
use VKMapperBundle\DependencyInjection\MapperBundleExtension;

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
        $container->registerExtension(new MapperBundleExtension());
        $container->addCompilerPass(new MappingCompilePass());
    }
}
