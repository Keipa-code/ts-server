<?php

declare(strict_types=1);

namespace App\Manage\Command\ListSubscriber\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=3, allowEmptyString=true)
     * @Assert\Choice({"ASC", "DESC"}, message="Wrong value in sort.")
     */
    public string $order = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=20, allowEmptyString=true)
     */
    public string $sort = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/\d/")
     * @Assert\Length(max=1000, allowEmptyString=true)
     */
    public string $pageNumber = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/\d/")
     */
    public int $rowCount = 50;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=11, allowEmptyString=true)
     * @Assert\Choice({"private", "juridical"}, message="Wrong value in type.")
     */
    public string $subscriberType = '';
}
