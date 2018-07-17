<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\MappedRelationsNodeDto;
use Tests\DataFixtures\Model\Relations\MappedRelationsNodeInfo;
use Tests\DataFixtures\Dto\MappedRelationsRootDto;

/**
 * Class RelationsMappingTest
 */
class RelationsMappingTest extends AbstractMapperTest
{
    /**
     * Test compiling
     *
     * @param array $parameters
     * @dataProvider relationsDataProvider
     */
    public function testArrayMapping(array $parameters): void
    {
        $mapper = $this->getMapper();
        /** @var MappedRelationsRootDto $dto */
        $dto = $mapper->convert($parameters, MappedRelationsRootDto::class);
        $this->assertInstanceOf(MappedRelationsNodeDto::class, $dto->nodeA);
        $this->assertInstanceOf(MappedRelationsNodeDto::class, $dto->nodeA->nodeA);
        $this->assertInstanceOf(MappedRelationsNodeDto::class, $dto->nodeB);
        $this->assertInstanceOf(MappedRelationsNodeDto::class, $dto->nodeB->nodeA);
        $this->assertContainsOnlyInstancesOf(MappedRelationsNodeInfo::class, $dto->event);

        $this->assertNodes($dto->nodeA, $parameters['node_a']);
        $this->assertNodes($dto->nodeA->nodeA, $parameters['node_a']['node_a']);
        $this->assertNodes($dto->nodeA->nodeA->nodeA, $parameters['node_a']['node_a']['node_a']);
        $this->assertNodes($dto->nodeB, $parameters['node_b']);
        $this->assertNodes($dto->nodeB->nodeA, $parameters['node_b']['node_a']);
        $this->assertNodes($dto->nodeB->nodeA->nodeA, $parameters['node_b']['node_a']['node_a']);
        $this->assertContainsEvents($dto->event, $parameters['event']);
    }

    /**
     * @param MappedRelationsNodeDto $node
     * @param array                  $nodeArr
     */
    private function assertNodes(MappedRelationsNodeDto $node, array $nodeArr): void
    {
        $this->assertEquals($node->propertyA, $nodeArr['property_a']);
        $this->assertEquals($node->propertyB, $nodeArr['property_b']);
        $this->assertEquals($node->propertyC, $nodeArr['property_c']);
    }

    /**
     * @param MappedRelationsNodeInfoDto[] $eventsCollection
     * @param array                        $eventsParameters
     */
    private function assertContainsEvents(array $eventsCollection, array $eventsParameters): void
    {
        foreach ($eventsParameters as $key => $event) {
            ['author' => $author, 'time' => $time] = $event;
            $this->assertEquals($eventsCollection[$key]->author, $author);
            $this->assertEquals($eventsCollection[$key]->time, $time);
        }
    }

    /**
     * @return array
     */
    public function relationsDataProvider(): array
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
                            'node_a' => [
                                    'property_a'=> 'propertyA1',
                                    'property_b'=> 'propertyB1',
                                    'property_c'=> 'propertyC1',
                            ],
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
                            'node_a' => [
                                'property_a'=> 'propertyA1',
                                'property_b'=> 'propertyB1',
                                'property_c'=> 'propertyC1',
                            ],
                        ],
                    ],
                    'event' => [
                        [
                            'author' => 'tester_1',
                            'time' => 1234,
                        ],
                        [
                            'author' => 'tester_2',
                            'time' => 12345,
                        ],
                        [
                            'author' => 'tester_3',
                            'time' => 123456,
                        ],
                    ],
                ],
            ],
        ];
    }
}
