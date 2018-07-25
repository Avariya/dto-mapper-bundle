<?php

namespace Tests\DataFixtures\Model\Rename;

use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\Map;
use VKMapperBundle\Annotation\MappingMeta\NamingStrategy\MapNamingStrategy;
use VKMapperBundle\Annotation\MappingMeta\SourceClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class RenameCustomerPropsSource
 *
 * @SourceClass(namingStrategies={
 *     @MapNamingStrategy(
 *      convert={
 *          @Map(from="propAA", to="fistName"),
 *          @Map(from="propBB", to="lastName"),
 *          @Map(from="propCC", to="department"),
 *          @Map(from="propDD", to="birthday")
 *     })
 * })
 */
class RenameCustomerPropsSource
{
    public $propAA = 'Ivan';
    public $propBB = 'Ivanov';
    public $propCC = 'Retail';

    /**
     * @Strategy\GetterStrategy(method="getBirthday")
     */
    public $propDD;

    /**
     * @return string
     */
    public function getBirthday(): string
    {
        return '2018-18-18';
    }
}
