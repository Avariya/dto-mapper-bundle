<?php

namespace MapperBundle\DependencyInjection\Compiler;

use MapperBundle\Mapping\MappingRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MappingCompilePass
 */
class MappingCompilePass implements CompilerPassInterface
{
    private const DTO_MAPPER_DESTINATION_TAG = 'dto_mapper.destination';

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $taggedObjects = $container->findTaggedServiceIds(self::DTO_MAPPER_DESTINATION_TAG);
        $definition = $container->getDefinition(MappingRegistry::class);

        foreach ($taggedObjects as $id => $tag) {
            $destinationClass = $container->findDefinition($id)->getClass();
            $definition->addMethodCall('registerMappedDestinationClass', [$destinationClass]);
        }
    }
}
