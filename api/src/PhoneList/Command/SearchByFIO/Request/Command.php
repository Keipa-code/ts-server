<?php

declare(strict_types=1);

namespace App\PhoneList\Command\SearchByFIO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Your name cannot contain a number"
     * )
     * @Assert\Length(max=30, allowEmptyString=true)
     */
    public string $fio = '';

    public array $row = [];
}