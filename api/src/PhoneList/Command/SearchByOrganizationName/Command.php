<?php

declare(strict_types=1);

namespace App\PhoneList\Command\SearchByOrganizationName;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\Length(max=30, allowEmptyString=true)
     */
    public string $organizationName = '';

    public array $row = [];
}
