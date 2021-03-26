<?php

declare(strict_types=1);

namespace App\Manage\Admin\Entity;

use App\Manage\Admin\Services\PasswordHasher;

class User
{
    private string $userName;
    private string $password;

    public function __construct(string $userName, string $password)
    {
        $this->userName = $userName;
        $this->password = $password;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }


    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }


    public function getPassword(): string
    {
        return $this->password;
    }


    public function setPassword(string $password): void
    {
        $hasher = new PasswordHasher();
        $this->password = $hasher->hash($password);
    }
}
