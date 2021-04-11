<?php

declare(strict_types=1);

namespace App\Manage\Command\Entity\Subscriber;

use DateTimeImmutable;

interface SubscriberInterface
{
    /**
     * Subscriber constructor.
     * @param Id $id
     * @param Phonenumber $phoneNumber
     * @param SubscriberType $subscriberType
     * @param DateTimeImmutable $date
     * @param array $subData
     */
    public function __construct(Id $id, Phonenumber $phoneNumber, SubscriberType $subscriberType, DateTimeImmutable $date, array $subData);

    public function getId(): Id;

    public function getPhonenumbers(): array;
}
