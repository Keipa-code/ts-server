<?php

declare(strict_types=1);

namespace App\Manage\Command\GetJuridicalList;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4, allowEmptyString=true)
     * @Assert\Choice({"ASC", "DESC"}, message="Wrong value in sort.")
     */
    public string $order = '';
    /**
     * @Assert\Length(max=20, allowEmptyString=true)
     */
    public string $sort = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/\d/")
     * @Assert\Length(max=1000, allowEmptyString=true)
     */
    public int $pageNumber = 1;
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/\d/")
     */
    public int $rowCount = 50;
    /**
     * @Assert\Length(max=30, allowEmptyString=true)
     */
    public string $fio = '';
    /**
     * @Assert\Length(min=4, max=20, allowEmptyString=true)
     */
    public string $phonenumber = '';
    /**
     * @Assert\Length(max=30, allowEmptyString=true)
     */
    public string $organizationName = '';
}
