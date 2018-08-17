<?php

namespace VKMapperBundle\Hydrator;

use DataMapper\Hydrator\HydratedClassesFactory;
use Symfony\Component\Cache\Simple\FilesystemCache;

/**
 * Class GeneratedHydratorCache
 */
class GeneratedHydratorCache
{
    private const CACHE_NAMESPACE = 'dto-mapper';

    /**
     * @var FilesystemCache
     */
    private $fileCache;

    /**
     * GeneratedHydratorCache constructor.
     *
     * @param string $cacheDir
     */
    public function __construct(string $cacheDir)
    {
        $this->fileCache = new FilesystemCache(self::CACHE_NAMESPACE, 0, $cacheDir);
        HydratedClassesFactory::setGeneratedClassesTargetDir($cacheDir . '/' . self::CACHE_NAMESPACE);
    }

    /**
     * Clean cache directory
     */
    public function cleanup(): void
    {
        $this->fileCache->clear();
    }

    /**
     * @param string $className
     */
    public function generateClass(string $className): void
    {
        HydratedClassesFactory::createHydratedClass($className);
    }
}
