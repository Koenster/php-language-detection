<?php

require_once 'vendor/autoload.php';

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
