<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;


abstract class Subscriber
{
    /**
     * @ORM\Column(type="subscriber_id")
     * @ORM\Id
     */
    protected Id $id;
    /**
     * @ORM\Column(type="subscriber_phone_number", unique=true)
     */
    protected PhoneNumber $phoneNumber;
    /**
     * @ORM\Column(type="subscriber_type", length=10)
     */
    protected SubscriberType $subscriberType;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    protected DateTimeImmutable $date;

    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    public function getSubscriberType(): SubscriberType
    {
        return $this->subscriberType;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}