<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    /**
     * @psalm-var Collection<array-key,PhoneNumber>
     * @ORM\OneToMany(targetEntity="PhoneDirectory", mappedBy="privateSubscriber", cascade={"all"}, orphanRemoval=true)
     */
    private Collection $phoneNumbers;


    public function __construct(
        Id $id,
        PhoneNumber $phoneNumber,
        DateTimeImmutable $date,
        array $subData
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->phoneNumbers = new ArrayCollection();
        $this->firstname = $subData['firstname'];
        $this->surname = $subData['surname'];
        $this->patronymic = $subData['patronymic'];
        $this->phoneNumbers->add(new PhoneDirectory($this, null, $phoneNumber));
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
        $this->firstname = $firstname;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
    }

    public function setPhoneNumbers(PrivateSubscriber $subscriber, PhoneNumber $phoneNumber)
    {
        $this->phoneNumbers->add(new PhoneDirectory($subscriber, null, $phoneNumber));
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

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getPhoneNumbers(): array
    {
        /** @var PhoneNumber[] */
        return $this->phoneNumbers->map(static function (PhoneDirectory $phoneNumber) {
            return $phoneNumber->getPhoneNumber();
        })->toArray();
    }
}