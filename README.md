# PHP localization / language detection script
Detects the preferred language from the browser and compares this with the available languages/locales to return the best language/locale to redirect.

## How to install

```
composer require koenster/php-language-detection
```

## How to use

```

use koenster\PHPLanguageDetection\BrowserLocalization;

$browser = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$default = 'nl-NL';
$available = ['nl-NL', 'nl-BE', 'en-GB', 'fr-FR'];


$browser = new BrowserLocalization();

$browser->setAvailable($available)
    ->setDefault($default)
    ->setPreferences($browser);

// Will return or a default or when available, the available locale.
echo $browser->detect();

```

##License

This Language Detection script is open-sourced software licensed under the MIT license.