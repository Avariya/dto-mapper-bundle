<?php

namespace VKMapperBundle;

use VKMapperBundle\DependencyInjection\Compiler\MappingCompilePass;
use VKMapperBundle\DependencyInjection\MapperBundleExtension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class VKMapperBundle
 */
class VKMapperBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->registerExtension(new MapperBundleExtension());
        $container->addCompilerPass(new MappingCompilePass());
    }
}
