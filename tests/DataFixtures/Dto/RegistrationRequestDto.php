<?php

namespace Tests\DataFixtures\Dto;

use MapperBundle\Mapping\Annotation\Meta\DestinationClass;

/**
 * Class RegistrationRequestDto
 * @DestinationClass
 *
 */
class RegistrationRequestDto
{
    /**
     * @var string|null
     */
    public $firstName;

    /**
     * @var string|null
     */
    public $lastName;

    /**
     * @var string|null
     */
    public $password;

    /**
     * @var string|null
     */
    public $city;

    /**
     * @var string|null
     */
    public $country;

    /**
     * @var string|null
     */
    public $email;

    /**
     * @var string|null
     */
    public $birthday;

    /**
     * @var array
     */
    public $personalInfo = [];

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return null|string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return null|string
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @return array
     */
    public function getPersonalInfo(): array
    {
        return $this->personalInfo;
    }
}
