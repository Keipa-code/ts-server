<?php

declare(strict_types=1);

namespace App\Manage\Command\Entity\Subscriber;

use DateTimeImmutable;

interface SubscriberInterface
{
    /**
     * Subscriber constructor.
     * @param Id $id
     * @param PhoneNumber $phoneNumber
     * @param DateTimeImmutable $date
     * @param array $subData
     */
    public function __construct(Id $id, PhoneNumber $phoneNumber, DateTimeImmutable $date, array $subData);

    public function getId(): Id;

    public function getPhoneNumbers(): array;
}
