<?php

namespace VK\DTOMapperBundle;

use VK\DTOMapperBundle\DependencyInjection\Compiler\MappingCompilePass;
use VK\DTOMapperBundle\DependencyInjection\MapperBundleExtension;

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
