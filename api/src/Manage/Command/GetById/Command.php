<?php

declare(strict_types=1);

namespace App\Manage\Command\GetById;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public string $id = '';
}
