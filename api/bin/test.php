<?php

declare(strict_types=1);

use App\Flusher;
use App\Manage\Command\AddSubscriber\Request\Handler;
use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use libphonenumber\PhoneNumberUtil;
use Psalm\PhpUnitPlugin\Plugin;

require __DIR__ . '/../vendor/autoload.php';

/*$value = "8 707 3999275";
$phoneUtil = PhoneNumberUtil::getInstance();
$kzNumber = $phoneUtil->parse($value, "KZ");
/*if (!$kzNumber->hasNationalNumber()) {
    return new InvalidArgumentException('Invalid phone number format');
}
$number = (string)$kzNumber->getNationalNumber();
$formattedNumber = $phoneUtil->formatOutOfCountryCallingNumber($kzNumber, 'KZ');*/
$filename = __DIR__.'/array.txt';
$data = file_get_contents($filename);
var_dump(unserialize($data));