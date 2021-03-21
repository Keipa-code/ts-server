<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$number = 'Маша-Альдин';

$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();




\Webmozart\Assert\Assert::unicodeLetters($number);