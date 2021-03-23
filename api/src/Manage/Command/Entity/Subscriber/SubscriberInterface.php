<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use DateTimeImmutable;


interface SubscriberInterface
{
    /**
     * Subscriber constructor.
     * @param Id $id
     * @param DateTimeImmutable $date
     * @param array $subData
     */
    public function __construct(Id $id, DateTimeImmutable $date, array $subData);
}