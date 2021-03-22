<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


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
            $this->value = (string)$kzNumber->getNationalNumber();
        } catch (NumberParseException $e) {
            echo $e->getMessage();
        }
    }


    public function getValue(): string
    {
        return $this->value;
    }
}