# OptionalLocaleBundle

This bundle allows you to remove the locale prefix on your routes.

# Installation

Add the OptionalLocaleBundle to your `composer.json`

```yaml
{
    "require": {
        "ashura/optional-locale-bundle": "~1.0"
    }
}
```

or simply run ```composer require ashura/optional-locale-bundle:~1.0```

Register the bundle in ``app/AppKernel.php``

```php
$bundles = array(
    // ...
    new Ashura\OptionalLocaleBundle\OptionalLocaleBundle(),
);
```