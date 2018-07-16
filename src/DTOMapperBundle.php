<?php

namespace DTOMapperBundle;

use DTOMapperBundle\DependencyInjection\Compiler\MappingCompilePass;
use DTOMapperBundle\DependencyInjection\MapperBundleExtension;

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
