<?php

namespace Tests;

use VK\DTOMapperBundle\DTOMapperBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * Class Kernel
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return $this->getProjectDir() . '/var/cache/' . $this->environment;
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return $this->getProjectDir() . '/var/log';
    }

    /**
     * @return \Symfony\Component\HttpKernel\Bundle\BundleInterface[]
     */
    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new DTOMapperBundle(),
        ];
    }

    /**
     * Add or import routes into your application.
     *
     *     $routes->import('config/routing.yml');
     *     $routes->add('/admin', 'AppBundle:Admin:dashboard', 'admin_dashboard');
     *
     * @param RouteCollectionBuilder $routes
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
    }

    /**
     * Configures the container.
     *
     * You can register extensions:
     *
     * $c->loadFromExtension('framework', array(
     *     'secret' => '%secret%'
     * ));
     *
     * Or services:
     *
     * $c->register('halloween', 'FooBundle\HalloweenProvider');
     *
     * Or parameters:
     *
     * $c->setParameter('halloween', 'lot of fun');
     *
     * @throws \Exception
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader)
    {
        $confDir = $this->getProjectDir() . '/tests/Resource/config/';
        $loader->load($confDir . 'test_services.yaml');
        $container->setParameter('kernel.secret', 'none');
    }
}
