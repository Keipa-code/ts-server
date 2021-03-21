<?php

declare(strict_types=1);


namespace App\Admin\Command\Entity\Subscriber;


use InvalidArgumentException;
use libphonenumber\NumberParseException;
use Webmozart\Assert\Assert;

class PhoneNumber
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::stringNotEmpty($value);
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $kzNumber = $phoneUtil->parse($value, "KZ");
            if (!$phoneUtil->isValidNumber($kzNumber)) {
                throw new InvalidArgumentException('Incorrect number.');
            };
            $this->value = (string)$kzNumber->getNationalNumber();
        } catch (NumberParseException $e) {
        }
    }


    public function getValue(): string
    {
        return $this->value;
    }
}