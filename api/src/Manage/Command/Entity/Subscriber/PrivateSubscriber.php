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
     * @ORM\Column(type="subscriber_type")
     */
    private SubscriberType $subscriberType;
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
     * @psalm-var Collection<array-key,PhoneDirectory>
     * @ORM\OneToMany(targetEntity="PhoneDirectory", mappedBy="privateSubscriber", cascade={"all"}, orphanRemoval=true)
     */
    private Collection $phonenumbers;


    public function __construct(
        Id $id,
        Phonenumber $phoneNumber,
        SubscriberType $subscriberType,
        DateTimeImmutable $date,
        array $subData
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->subscriberType = $subscriberType;
        $this->phonenumbers = new ArrayCollection();
        /** @var string[] $subData */
        $this->firstname = $subData['firstname'];
        $this->surname = $subData['surname'];
        $this->patronymic = $subData['patronymic'];
        $this->phonenumbers->add(new PhoneDirectory($this, null, $phoneNumber));
    }

    public function setPhonenumbers(PrivateSubscriber $subscriber, Phonenumber $phoneNumber): void
    {
        $this->phonenumbers->add(new PhoneDirectory($subscriber, null, $phoneNumber));
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

    public function setUpdatedData(Phonenumber $phonenumber, $subData): void
    {
        /** @var string[] $subData */
        $this->firstname = $subData['firstname'];
        $this->surname = $subData['surname'];
        $this->patronymic = $subData['patronymic'];
        $this->phonenumbers->add(new PhoneDirectory($this, null, $phonenumber));
    }

    public function getPhonenumbers(): array
    {
        /** @var Phonenumber[] */
        return $this->phonenumbers->map(static function (PhoneDirectory $phoneNumber) {
            return $phoneNumber->getPhonenumber();
        })->toArray();
    }

    public function getInListFormat(): array
    {
        $row = [
            'phonenumber' => $this->getPhonenumbers()['0']->getFormattedNumber(),
            'rowValue' => '',
            'id' => $this->id->getValue()
        ];

        $row['rowValue'] = $this->firstname . ' ' . $this->surname . ' ' . $this->patronymic;
        return $row;
    }
}
