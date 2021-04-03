<?php

declare(strict_types=1);

namespace App\PhoneList\Command\SearchByNumber\Request;

use Symfony\Component\Validator\Constraints as Assert;


class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=20, allowEmptyString=true)
     * @Assert\Regex(pattern="/[0-9\s\-()]{8,20}/")
     */
    public string $phonenumber = '';

    public array $row = [];
}