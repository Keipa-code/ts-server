<?php

declare(strict_types=1);

namespace App\PhoneList\Command\SearchByFIO;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\Length(max=30, allowEmptyString=true)
     */
    public string $fio = '';
    /**
     * @Assert\Length(min=8, max=20, allowEmptyString=true)
     */
    public string $phonenumber = '';
    /**
     * @Assert\Length(max=30, allowEmptyString=true)
     */
    public string $organizationName = '';

}