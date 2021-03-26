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
    /**
     * @ORM\Column(type="string", length=10)
     */
    private string $subscriberType;

    public function __construct(string $value, SubscriberType $type)
    {
        Assert::stringNotEmpty($value);
        $phoneUtil = PhoneNumberUtil::getInstance();
        $kzNumber = $phoneUtil->parse($value, "KZ");
        /*if (!$kzNumber->hasNationalNumber()) {
            return new InvalidArgumentException('Invalid phone number format');
        }*/
        $this->number = (string)$kzNumber->getNationalNumber();

        $this->subscriberType = $type->getSubscriberType();
    }


    public function getNumber(): string
    {
        return $this->number;
    }

    public function getSubscriberType(): string
    {
        return $this->subscriberType;
    }
}
