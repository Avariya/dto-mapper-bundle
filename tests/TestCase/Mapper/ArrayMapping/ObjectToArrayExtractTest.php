<?php

namespace Tests\TestCase\Mapper\ArrayMapping;

use MapperBundle\Hydrator\NamingStrategy\UnderscoreNamingStrategy;
use Tests\DataFixtures\Dto\RegistrationResponseDto;
use Tests\TestCase\Mapper\MapperTrait;

use PHPUnit\Framework\TestCase;

/**
 * Class ObjectToArrayExtractTest
 */
class ObjectToArrayExtractTest extends TestCase
{
    use MapperTrait;

    /**
     */
    public function tesObjectToUnderscoreArrayExtraction(): void
    {
        $namingStrategy = new UnderscoreNamingStrategy();
        $dto = new RegistrationResponseDto();
        $mapper = $this->createMapper($namingStrategy);
        $extracted = $mapper->extract($dto);

        $this->assertEquals($dto->getFirstName(), $extracted['first_name']);
        $this->assertEquals($dto->getLastName(), $extracted['last_name']);
        $this->assertEquals($dto->getPassword(), $extracted['password']);
        $this->assertEquals($dto->getCity(), $extracted['city']);
        $this->assertEquals($dto->getCountry(), $extracted['country']);
        $this->assertEquals($dto->getEmail(), $extracted['email']);
        $this->assertEquals($dto->getBirthday(), $extracted['birthday']);
        $this->assertEquals($dto->getPersonalInfo(), $extracted['personal_info']);
    }
}
