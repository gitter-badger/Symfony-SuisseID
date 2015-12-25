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

or simply run 
```bash
$ composer require ashura/optional-locale-bundle:~1.0
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.


Register the bundle in ``app/AppKernel.php``

```php
$bundles = array(
    // ...
    new Ashura\OptionalLocaleBundle\OptionalLocaleBundle(),
);
```

Add the following code to your `routing.yml`

```yaml
optional_locale:
    resource: "@OptionalLocaleBundle/Resources/config/routing.yml"
    prefix:   /
```

Now add your locales you want to add to your routing:

```yaml
 app:
     resource: "@AppBundle/Controller/"
     prefix:   /{_locale}
     type:     annotation
     requirements:
          # The first "|" is important so it will work
         _locale: "|de|en"
```

You are done. 
Now the routes will be automatically handled. Don't forget to add your translations.