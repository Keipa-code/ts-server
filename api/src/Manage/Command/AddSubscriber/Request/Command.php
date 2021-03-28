<?php

declare(strict_types=1);

namespace App\Manage\Command\AddSubscriber\Request;

use Symfony\Component\Validator\Constraints as Assert;


class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=20, allowEmptyString=true)
     * @Assert\Regex(pattern="/[0-9\s\-()]{8,20}/")
     */
    public string $phoneNumber = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=11, allowEmptyString=true)
     * @Assert\Choice({"private", "juridical"}, message="Wrong value in type.")
     */
    public string $subscriberType = '';
    /**
     * @Assert\All({@Assert\NotBlank(), @Assert\Length(max=50, allowEmptyString=true)})
     */
    public array $subData = [];

}
