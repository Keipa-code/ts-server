<?php

declare(strict_types=1);


namespace App\PhoneList\Command\Entity;


use Webmozart\Assert\Assert;

class Row
{
    private array $rows;

    public function __construct($phonenumber ,$data)
    {
        Assert::notEmpty($data);
        Assert::isArray($data);
        unset($data['id']);
        unset($data['date']);
        return $phonenumber;
    }
}