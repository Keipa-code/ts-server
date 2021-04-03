<?php

declare(strict_types=1);

namespace App\Auth\Command\SignIn;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=20, allowEmptyString=true)
     */
    public string $username = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=30, allowEmptyString=true)
     */
    public string $password = '';
}
