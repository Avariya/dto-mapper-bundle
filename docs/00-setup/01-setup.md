# Setup

Register bundle in bundles.php file.
```php
<?php

return [
    VKMapperBundle\VKMapperBundle::class => ['all' => true],
];
```

Tag directory with classes that you want add to mapping.
```yaml
    Tests\DataFixtures\Dto\:
      resource: '../../DataFixtures/Dto/*'
      tags:
        - { name: dto_mapper.annotated }
    
    Tests\DataFixtures\Model\:
      resource: '../../DataFixtures/Model/*'
      tags:
        - { name: dto_mapper.annotated }
```

[back](..)