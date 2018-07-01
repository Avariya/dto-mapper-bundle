<?php

namespace Tests\DataFixtures\Dto;

use MapperBundle\Mapping\Annotation\Meta;
use MapperBundle\Mapping\Annotation\Meta\Strategy;

/**
 * Class RelationsRequestDto
 * @Meta\DestinationClass
 * @Meta\NamingStrategy\UnderscoreNamingStrategy
 */
class RelationsRequestDto
{
    /**
     * @Strategy\CollectionStrategy(targetClass="Tests\DataFixtures\Dto\RegistrationRequestDto")
     *
     * @var RegistrationRequestDto[]
     */
    public $registrationsRequests = [];

    /**
     * @Strategy\MultiCollectionStrategy(targetClass="Tests\DataFixtures\Dto\PersonalInfoDto")
     *
     * @var PersonalInfoDto
     */
    public $personalInfo;

    /**
     * @var array
     */
    public $extra = [];

    /**
     * @return RegistrationRequestDto[]
     */
    public function getRegistrationsRequests(): array
    {
        return $this->registrationsRequests;
    }

    /**
     * @return PersonalInfoDto
     */
    public function getPersonalInfo(): PersonalInfoDto
    {
        return $this->personalInfo;
    }

    /**
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
    }
}
