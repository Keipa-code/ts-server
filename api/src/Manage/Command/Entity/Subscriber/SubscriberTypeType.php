<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use Doctrine\DBAL\Platforms\AbstractPlatform;

class SubscriberTypeType
{
    public const NAME = 'subscriber_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof SubscriberType ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new SubscriberType((string)$value) : null;
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