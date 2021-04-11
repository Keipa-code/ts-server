<?php

declare(strict_types=1);

namespace App\Manage\Command\Entity\Subscriber;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Phonenumber
{
    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $number;

    private string $formattedNumber;

    public function __construct(string $value)
    {
        Assert::stringNotEmpty($value);
        $phoneUtil = PhoneNumberUtil::getInstance();
        $kzNumber = $phoneUtil->parse($value, "KZ");
        /*if (!$kzNumber->hasNationalNumber()) {
            return new InvalidArgumentException('Invalid phone number format');
        }*/
        $this->number = (string)$kzNumber->getNationalNumber();
        $this->formattedNumber = $phoneUtil->formatOutOfCountryCallingNumber($kzNumber, 'KZ');
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getFormattedNumber(): string
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $kzNumber = $phoneUtil->parse($this->number, "KZ");
        return $phoneUtil->formatOutOfCountryCallingNumber($kzNumber, 'KZ');
    }

    public function setNumber(string $number): void
    {
        Assert::stringNotEmpty($number);
        $phoneUtil = PhoneNumberUtil::getInstance();
        $kzNumber = $phoneUtil->parse($number, "KZ");
        /*if (!$kzNumber->hasNationalNumber()) {
            return new InvalidArgumentException('Invalid phone number format');
        }*/
        $this->number = (string)$kzNumber->getNationalNumber();
    }
}
