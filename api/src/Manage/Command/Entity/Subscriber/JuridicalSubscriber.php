<?php

declare(strict_types=1);

namespace App\Manage\Command\Entity\Subscriber;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscriber_juridical")
 */
class JuridicalSubscriber implements SubscriberInterface
{
    /**
     * @ORM\Column(type="subscriber_id")
     * @ORM\Id
     */
    protected Id $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    protected DateTimeImmutable $date;
    /**
     * @ORM\Column(type="subscriber_type")
     */
    private SubscriberType $subscriberType;
    /**
     * @ORM\Column
     */
    private string $organizationName;
    /**
     * @ORM\Column
     */
    private string $departmentName;
    /**
     * @ORM\Column
     */
    private string $country;
    /**
     * @ORM\Column
     */
    private string $city;
    /**
     * @ORM\Column
     */
    private string $street;
    /**
     * @ORM\Column
     */
    private string $houseNumber;
    /**
     * @ORM\Column(nullable=true)
     */
    private ?string $floatNumber = null;
    /**
     * @psalm-var Collection<array-key,PhoneDirectory>
     * @ORM\OneToMany(targetEntity="PhoneDirectory",
     *     mappedBy="juridicalSubscriber", cascade={"all"}, orphanRemoval=true)
     */
    private Collection $phonenumbers;

    public function __construct(
        Id $id,
        Phonenumber $phoneNumber,
        SubscriberType $subscriberType,
        DateTimeImmutable $date,
        $subData
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->subscriberType = $subscriberType;
        $this->phonenumbers = new ArrayCollection();
        /**
         * @var string[] $subData
         */
        $this->organizationName = $subData['organizationName'];
        $this->departmentName = $subData['departmentName'];
        $this->country = $subData['country'];
        $this->city = $subData['city'];
        $this->street = $subData['street'];
        $this->houseNumber = $subData['houseNumber'];
        $this->floatNumber = $subData['floatNumber'] ?? null;
        $this->phonenumbers->add(new PhoneDirectory(null, $this, $phoneNumber));
    }

    public function setPhoneNumbers(SubscriberInterface $subscriber, Phonenumber $phoneNumber): void
    {
        /** @var JuridicalSubscriber|null $subscriber */
        $this->phonenumbers->add(new PhoneDirectory(null, $subscriber, $phoneNumber));
    }

    public function setUpdatedData(Phonenumber $phonenumber, $subData): void
    {
        /**
         * @var string[] $subData
         */
        $this->organizationName = $subData['organizationName'];
        $this->departmentName = $subData['departmentName'];
        $this->country = $subData['country'];
        $this->city = $subData['city'];
        $this->street = $subData['street'];
        $this->houseNumber = $subData['houseNumber'];
        $this->floatNumber = $subData['floatNumber'] ?? null;
        $this->phonenumbers->add(new PhoneDirectory(null, $this, $phonenumber));
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
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
            'rowValue' => ''
        ];

        $row['rowValue'] = $this->organizationName . ' ' . $this->departmentName . ' ' . $this->country
            . ' ' . $this->city . ' ' . $this->street . ' ' . $this->houseNumber
            . ' ' . $this->floatNumber;
        return $row;
    }

    public function getSubscriberType(): SubscriberType
    {
        return $this->subscriberType;
    }

    public function getOrganizationName(): string
    {
        return $this->organizationName;
    }

    public function getDepartmentName(): string
    {
        return $this->departmentName;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    public function getFloatNumber(): ?string
    {
        return $this->floatNumber;
    }

}
