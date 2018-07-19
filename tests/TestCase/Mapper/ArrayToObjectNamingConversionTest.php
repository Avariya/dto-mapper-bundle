<?php

namespace Tests\TestCase\Mapper;

use Tests\DataFixtures\Dto\UnderscoreArrayToObjectDto;

/**
 * Class ArrayToObjectNamingConversionTest
 */
class ArrayToObjectNamingConversionTest extends AbstractMapperTest
{
    /**
     * @param array $source
     *
     * @dataProvider sourcesProvider
     */
    public function testKeysConversion(array $source): void
    {
        $mapper = $this->getMapper();

        $this->assertPropsValues(
            $mapper->convert($source, new UnderscoreArrayToObjectDto()),
            $source
        );

        $this->assertPropsValues(
            $mapper->convert($source, UnderscoreArrayToObjectDto::class),
            $source
        );
    }

    /**
     * @return array
     */
    public function sourcesProvider(): array
    {
        return [
            [
                [
                    'aOption' => 11,
                    'bOption' => 22,
                    'cOption' => [
                        'aOption' => 11,
                        'bOption' => 22,
                    ],
                ],
            ],
            [
                [
                    'a_option' => 111,
                    'b_option' => 222,
                    'c_option' => [
                        'a_option' => 111,
                        'b_option' => 222,
                    ],
                ],
            ],
        ];
    }

    /**
     * @param UnderscoreArrayToObjectDto $dto
     * @param array                      $source
     */
    private function assertPropsValues(UnderscoreArrayToObjectDto $dto, array $source): void
    {
        [$aOption, $bOption, $cOption] = \array_values($source);
        [$innerA, $innerB] = \array_values($cOption);

        $this->assertEquals($aOption, $dto->aOption);
        $this->assertEquals($bOption, $dto->bOption);
        $this->assertEquals($innerA, $dto->cOption->aOption);
        $this->assertEquals($innerB, $dto->cOption->bOption);
    }
}
