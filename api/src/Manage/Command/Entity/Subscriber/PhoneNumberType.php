<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class PhoneNumberType extends StringType
{
    public const NAME = 'subscriber_phone_number';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof PhoneNumber ? $value->getPhoneNumber() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new PhoneNumber((string)$value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}