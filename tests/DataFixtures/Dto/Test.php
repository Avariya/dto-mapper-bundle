<?php

namespace Tests\DataFixtures\Dto;

use MapperBundle\Mapping\Annotation\Meta\DestinationClass;

/**
 * Class Test
 * @DestinationClass
 */
class Test
{
    /**
     * @HydrationStrategy(name="")
     */
    public $birthday;
}

///**
// * @PropertySource(targetClass="SourceClass", targetProperty="phone")
// *
// * @var PersonalInfoDto
// */
//public $contact;
//
///**
// * @PropertyGetter(targetClass="SourceClass", method="getFullName")
// *
// * @var PersonalInfoDto
// */
//public $name;
//