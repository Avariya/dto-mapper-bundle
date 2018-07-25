<?php

namespace Tests\DataFixtures\Model\Rename;

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;

/**
 * Class CustomerInfoDto
 * @DestinationClass
 */
class CustomerInfoDto
{
    public $fistName;
    public $lastName;
    public $department;
    public $birthday;
}
