<?php

namespace VKMapperBundle\Hydrator;

use DataMapper\Hydrator\HydratedClassesFactory;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class GeneratedHydratorCache
 */
class GeneratedHydratorCache
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $cacheDir;

    /**
     * @var HydratedClassesFactory
     */
    private $hydratedClassesFactory;

    /**
     * GeneratedHydratorCache constructor.
     *
     * @param Filesystem             $filesystem
     * @param string                 $cacheDir
     * @param HydratedClassesFactory $hydratedClassesFactory
     */
    public function __construct(
        Filesystem $filesystem,
        HydratedClassesFactory $hydratedClassesFactory,
        string $cacheDir
    ) {
        $this->cacheDir = $cacheDir;
        $this->filesystem= $filesystem;
        $this->hydratedClassesFactory = $hydratedClassesFactory;
    }

    /**
     * Hello
     */
    public function createStorage(): void
    {
        $this->filesystem->mkdir($this->cacheDir);
    }

    /**
     * Clean cache directory
     */
    public function cleanup(): void
    {
        $this->filesystem->remove($this->cacheDir);
        $this->createStorage();
    }

    /**
     * @param string $className
     */
    public function generateClass(string $className): void
    {
        $this->hydratedClassesFactory->extractHydratedClass($className);
    }
}
