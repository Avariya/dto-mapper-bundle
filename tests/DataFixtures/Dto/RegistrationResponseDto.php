<?php

namespace Tests\DataFixtures\Dto;

/**
 * Class RegistrationResponseDto
 */
class RegistrationResponseDto
{
    /**
     * @var string
     */
    public $firstName = 'Ivan';

    /**
     * @var string
     */
    public $lastName = 'Ivanov';

    /**
     * @var string
     */
    public $password = 'strpass';

    /**
     * @var string
     */
    public $city = 'Kiev';

    /**
     * @var string
     */
    public $country = 'Ukraine';

    /**
     * @var string
     */
    public $email = 'ivan@gmail.com';

    /**
     * @var string
     */
    public $birthday = '20/12/01';

    /**
     * @var array
     */
    public $personalInfo = [
        'a_a' => 1,
        'b_b' => 2,
    ];

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getBirthday(): string
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
