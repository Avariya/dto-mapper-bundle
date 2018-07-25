
# Strategy Registry Annotation

Use strategy Registry to combine all property strategies rules in one.

Example:
```php

<?php

use VKMapperBundle\Annotation\MappingMeta\DestinationClass;
use VKMapperBundle\Annotation\MappingMeta\Strategy;

/**
 * Class PropertyMappedByStrategyDTO
 * @DestinationClass
 */
class PropertyMappedByStrategyDTO
{
    /**
     * @Strategy\StrategyRegister(for={
     *      @Strategy\GetterStrategy(source="GeneralSourceA", method="getMe"),
     *      @Strategy\ServiceClosureStrategy(
     *          source="GeneralSourceB",
     *          provider="serviceId",
     *          method="getClosure"
     *      ),
     *      @Strategy\StaticClosureStrategy(
     *              source="GeneralSourceC",
     *              provider="Tests\DataFixtures\Service\ClosureStrategyService",
     *              method="getStaticClosure"
     *      ),
     *      @Strategy\XPathStrategy(source="GeneralSourceD", xPath="some.example.path"),
     *      @Strategy\ChainStrategy(
     *          source="GeneralSourceE",
     *          list={
     *              @Strategy\GetterStrategy(method="getMe"),
     *              @Strategy\StaticClosureStrategy(
     *                  provider="Tests\DataFixtures\Service\ClosureStrategyService",
     *                  method="getStaticClosure"
     *              )
     *           }
     *      )
     * })
     * @Strategy\XPathStrategy(source="GeneralSourceF", xPath="some.example.path")
     */
    public $testPropertyB;
}

```