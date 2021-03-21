<?php

declare(strict_types=1);


namespace App\Admin\Command\Entity\Subscriber;


use DateTimeImmutable;

abstract class Subscriber
{
    protected PhoneNumber $phoneNumber;
    protected string $subscriberType;
    protected Id $id;
    protected DateTimeImmutable $date;
}