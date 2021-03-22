<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscriber_private")
 */
class PrivateSubscriber extends Subscriber
{

    /**
     * @ORM\Column
     */
    private string $firstname;
    /**
     * @ORM\Column
     */
    private string $surname;
    /**
     * @ORM\Column
     */
    private string $patronymic;


    public function __construct(
        Id $id,
        DateTimeImmutable $date,
        PhoneNumber $phoneNumber,
        SubscriberType $subscriberType,
        string $firstname,
        string $surname,
        string $patronymic
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->phoneNumber = $phoneNumber;
        $this->subscriberType = $subscriberType;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
    }

    public function updateSubscriber(
        PhoneNumber $phoneNumber,
        SubscriberType $subscriberType,
        string $firstname,
        string $surname,
        string $patronymic
    )
    {
        $this->date = new DateTimeImmutable();
        $this->phoneNumber = $phoneNumber;
        $this->subscriberType = $subscriberType;
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getPatronymic(): string
    {
        return $this->patronymic;
    }
}