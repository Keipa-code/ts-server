<?php

declare(strict_types=1);

namespace App\Manage\Command\RemoveSubscriber\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=20, max=40)
     */
    public string $id = '';
}
