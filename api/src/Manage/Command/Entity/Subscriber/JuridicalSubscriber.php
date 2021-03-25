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
     * @psalm-var Collection<array-key,PhoneNumber>
     * @ORM\OneToMany(targetEntity="PhoneDirectory", mappedBy="juridicalSubscriber", cascade={"all"}, orphanRemoval=true)
     */
    private Collection $phoneNumbers;

    public function __construct(
        Id $id,
        PhoneNumber $phoneNumber,
        DateTimeImmutable $date,
        $subData
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->phoneNumbers = new ArrayCollection();
        $this->organizationName = $subData['organizationName'];
        $this->departmentName = $subData['departmentName'];
        $this->country = $subData['country'];
        $this->city = $subData['city'];
        $this->street = $subData['street'];
        $this->houseNumber = $subData['houseNumber'];
        $this->floatNumber = $subData['floatNumber'] ?? null;
        $this->phoneNumbers->add(new PhoneDirectory(null, $this, $phoneNumber));
    }

    public function updateSubscriber(
        PhoneNumber $phoneNumber,
        SubscriberType $subscriberType,
        string $organizationName,
        string $departmentName,
        string $country,
        string $city,
        string $street,
        string $houseNumber,
        ?string $floatNumber = null
    )
    {
        $this->date = new DateTimeImmutable();
        $this->phoneNumber = $phoneNumber;
        $this->subscriberType = $subscriberType;
        $this->organizationName = $organizationName;
        $this->departmentName = $departmentName;
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->floatNumber = $floatNumber;
    }

    public function setPhoneNumbers(SubscriberInterface $subscriber, PhoneNumber $phoneNumber)
    {
        $this->phoneNumbers->add(new PhoneDirectory(null, $subscriber, $phoneNumber));
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

    public function getFloatNumber(): string
    {
        return $this->floatNumber;
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