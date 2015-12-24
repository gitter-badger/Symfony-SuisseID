Symfony Base 2.8
================

A Symfony project created on December 24, 2015, 7:35 am.

This repository was created as a blueprint for Symfony applications.

Feel free to fork this repo.

# Installation

# Add or remove languages

All languages are configured in YourApp/app/config/routing.yml

```yaml
 app:
     resource: "@AppBundle/Controller/"
     prefix:   /{_locale}
     type:     annotation
     requirements:
         # The first "|" makes the locale optional
         _locale: "|de|en"
```

You can change the _locale parameter however you want. Maybe you want to add russian:

```yaml
 app:
     resource: "@AppBundle/Controller/"
     prefix:   /{_locale}
     type:     annotation
     requirements:
         _locale: "|de|en|ru"
```

After changing that, you would add the translations file to: 

YourApp/src/AppBundle/Resources/translations/messages.{The new locale you added}.yml