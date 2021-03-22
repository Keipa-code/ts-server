<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$value = 'not phone number';

    $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

try {
    $kzNumber = $phoneUtil->parse($value, "KZ");
    var_dump($kzNumber);
} catch (\libphonenumber\NumberParseException $e) {
    echo $e->getMessage();
}