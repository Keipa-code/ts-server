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
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=11, allowEmptyString=true)
     * @Assert\Choice({"private", "juridical"}, message="Wrong value in type.")
     */
    public string $subscriberType = '';
}
