<?php

declare(strict_types=1);


namespace App\Manage\Command\UpdateSubscriber\Request;


class Command
{
    public string $id = '';
    public string $date = '';
    public string $phoneNumber = '';
    public string $subscriberType = '';

    //Частное лицо
    public string $firstname = '';
    public string $surname = '';
    public string $patronymic = '';

    //Организация
    public string $organizationName = '';
    public string $departmentName = '';
    public string $country = '';
    public string $city = '';
    public string $street = '';
    public string $houseNumber = '';
    public string $floatNumber = '';
}