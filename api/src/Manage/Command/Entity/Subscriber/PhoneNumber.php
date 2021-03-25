<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use libphonenumber\NumberParseException;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable()
 */
class PhoneNumber
{
    /**
     * @ORM\Column(type="subscriber_phone_number", unique=true)
     */
    private string $phoneNumber;
    /**
     * @ORM\Column(type="subscriber_type", length=10)
     */
    private string $subscriberType;

    public function __construct(string $value, SubscriberType $type)
    {
        Assert::stringNotEmpty($value);
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $kzNumber = $phoneUtil->parse($value, "KZ");
            $this->phoneNumber = (string)$kzNumber->getNationalNumber();
        } catch (NumberParseException $e) {
            echo $e->getMessage();
        }
        $this->subscriberType = $type->getSubscriberType();
    }


    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getSubscriberType(): string
    {
        return $this->subscriberType;
    }
}