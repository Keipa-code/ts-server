<?php

declare(strict_types=1);

namespace App\Auth\Entity;

use App\Auth\Services\PasswordHasher;
use App\Manage\Command\Entity\Subscriber\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="admins")
 */
class Admin
{
    /**
     * @ORM\Column(type="subscriber_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;
    /**
     * @ORM\Column
     */
    private string $userName;
    /**
     * @ORM\Column
     */
    private string $passwordHash;

    public function __construct(Id $id, string $userName, string $passwordHash)
    {
        $this->id = $id;
        $this->date = new DateTimeImmutable();
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }


    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }


    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }


    public function setPasswordHash(string $password): void
    {
        $hasher = new PasswordHasher();
        $this->passwordHash = $hasher->hash($password);
    }
}
