<?php

declare(strict_types=1);

namespace App\Manage\Command\UpdateSubscriber\Request;

class Command
{
    public string $id = '';
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
}
