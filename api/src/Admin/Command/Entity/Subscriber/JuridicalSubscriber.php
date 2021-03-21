<?php

declare(strict_types=1);


namespace App\Admin\Command\Entity\Subscriber;


use DateTimeImmutable;

class JuridicalSubscriber extends Subscriber
{


    private string $organizationName;
    private string $departmentName;
    private string $country;
    private string $city;
    private string $street;
    private string $houseNumber;
    private string $floatNumber;

    public function __construct(
        Id $id,
        DateTimeImmutable $date,
        string $phoneNumber,
        string $subscriberType,
        string $organizationName,
        string $departmentName,
        string $country,
        string $city,
        string $street,
        string $houseNumber,
        string $floatNumber
    )
    {
        $this->id = $id;
        $this->date = $date;
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
}