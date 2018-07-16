<?php

namespace Tests\TestCase\Mapper;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use DataMapper\MapperInterface;
use Tests\DataFixtures\Dto\MappedRelationsRootDto;
use Tests\TestCase\Kernel;

/**
 * Class MappingRegisterPassTest
 */
class MappingRegisterPassTest extends KernelTestCase
{
    /**
     * Test compiling
     * @param array $arr
     * @dataProvider getRelationsData
     */
    public function testArrayMapping(array $arr): void
    {
        $k = new Kernel('test', true);
        $k->boot();
        /** @var MapperInterface $m */
        $c = $k->getContainer();
        $m =  $c->get(MapperInterface::class);
        $dto = $m->convert($arr, MappedRelationsRootDto::class);
        $this->assertTrue(true);
    }

    /**
     * @return array
     */
    public function getRelationsData(): array
    {
        return [
            [
                [
                    'node_a' => [
                        'property_a'=> 'propertyA',
                        'property_b'=> 'propertyB',
                        'property_c'=> 'propertyC',
                        'node_a' => [
                            'property_a'=> 'propertyA1',
                            'property_b'=> 'propertyB1',
                            'property_c'=> 'propertyC1',
                        ],
                    ],
                    'node_b' => [
                        'property_a'=> 'propertyA',
                        'property_b'=> 'propertyB',
                        'property_c'=> 'propertyC',
                        'node_a' => [
                            'property_a'=> 'propertyA1',
                            'property_b'=> 'propertyB1',
                            'property_c'=> 'propertyC1',
                        ],
                    ],
                    'event' => [
                        [
                            'author' => 'tester_1',
                            'time' => 1234
                        ],
                        [
                            'author' => 'tester_2',
                            'time' => 12345
                        ],
                        [
                            'author' => 'tester_3',
                            'time' => 123456
                        ],
                    ],
                ],
            ],
        ];
    }
}
