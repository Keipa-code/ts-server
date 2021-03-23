<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscriber_private")
 */
class PrivateSubscriber implements SubscriberInterface
{
    /**
     * @ORM\Column(type="subscriber_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;
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
        array $subData
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->phoneNumber = $subData[''];
        $this->firstname = $subData['firstname'];
        $this->surname = $subData['surname'];
        $this->patronymic = $subData['patronymic'];
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


    public function getId(): Id
    {
        return $this->id;
    }
}