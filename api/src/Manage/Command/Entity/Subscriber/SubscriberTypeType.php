<?php

declare(strict_types=1);

namespace App\Manage\Command\Entity\Subscriber;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class SubscriberTypeType extends StringType
{
    public const NAME = 'subscriber_type';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof SubscriberType ? $value->getSubscriberType() : $value;
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
