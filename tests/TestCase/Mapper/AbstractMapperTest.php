<?php

namespace Tests\TestCase\Mapper;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DataMapper\MapperInterface;

/**
 * Class AbstractMapperTest
 */
abstract class AbstractMapperTest extends KernelTestCase
{
    /**
     */
    public function setUp(): void
    {
        self::bootKernel();
    }

    /**
     * @return MapperInterface
     */
    protected function getMapper(): MapperInterface
    {
        return self::$container->get(MapperInterface::class);
    }
}
