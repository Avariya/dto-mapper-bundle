<?php

namespace Tests\TestCase\Mapper;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DataMapper\MapperInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AbstractMapperTest
 */
abstract class AbstractMapperTest extends KernelTestCase
{
    /**
     * @var MapperInterface
     */
    private $mapper;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $kernel = self::bootKernel();
        $this->mapper = $kernel->getContainer()->get(MapperInterface::class);
    }

    /**
     * @return MapperInterface
     */
    protected function getMapper(): MapperInterface
    {
        return $this->mapper;
    }
}
