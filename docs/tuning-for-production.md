
## Tuning for Production

By default, GeneratedHydrator will generate hydrators on every new request.
While this is relatively fast, it will cause I/O operations, and you can
achieve even better performance by pre-generating your hydrators and telling
your application to autoload them instead of generating new ones at each run.

Avoiding regeneration involves:

 1. pre-generating your hydrators
 2. ensuring that your autoloader is aware of them

The instructions that follow assume you are using Composer.

### Pre-generating your hydrators

There is no built-in way to bulk-generate all required hydrators, so you will need
to do so on your own.

Here is a simple snippet you can use to accomplish this:

```php
require '/path/to/vendor/autoload.php'; // composer autoloader

// classes for which we want to pre-generate the hydrators
$classes = [
    \My\Namespace\ClassOne::class,
    \My\Namespace\ClassTwo::class,
    \My\Namespace\ClassThree::class,
];

foreach ($classes as $class) {
    $config = new \GeneratedHydrator\Configuration($class);

    $config->setGeneratedClassesTargetDir('/path/to/target-dir');
    $config->createFactory()->getHydratorClass();
}
```

Just add all the classes for which you need hydrators to the `$classes` array,
and have your deployment process run this script.
When complete, all of the hydrators you need will be available in `/path/to/target-dir`.

### Making the autoloader aware of your hydrators

Using your pre-generated hydrators is as simple as adding the generation target
directory to your `composer.json`:

```json
{
    "autoload": {
        "classmap": [
            "/path/to/target-dir"
        ]
    }
}
```

After generating your hydrators, have your deployment script run `composer dump-autoload`
to regenerate your autoloader.
From now on, `GeneratedHydrator` will skip code generation and I/O if a generated class already
exists.