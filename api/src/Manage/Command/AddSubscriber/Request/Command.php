<?php

declare(strict_types=1);

namespace App\Manage\Command\AddSubscriber\Request;

class Command
{
    public string $phoneNumber = '';
    public string $subscriberType = '';

    public array $subData = [
        //Частное лицо
        'private' => [
            'firstname' => '',
            'surname' => '',
            'patronymic' => '',
        ],

        //Организация
        'juridical' => [
            'organizationName' => '',
            'departmentName' => '',
            'country' => '',
            'city' => '',
            'street' => '',
            'houseNumber' => '',
            'floatNumber' => '',
        ],
    ];
    /*//Частное лицо
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
    public string $floatNumber = '';*/
}
