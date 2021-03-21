<?php

declare(strict_types=1);


namespace App\Admin\Command\Entity\Subscriber;


use DateTimeImmutable;

class PrivateSubscriber extends Subscriber
{

    private string $firstname;
    private string $surname;
    private string $patronymic;

    public function __construct(
        Id $id,
        DateTimeImmutable $date,
        PhoneNumber $phoneNumber,
        string $subscriberType,
        string $firstname,
        string $surname,
        string $patronymic
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->phoneNumber = $phoneNumber;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
        $this->subscriberType = $subscriberType;
    }
}