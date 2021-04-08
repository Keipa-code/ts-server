<?php

declare(strict_types=1);

namespace App\Auth\Command\SignIn;

use App\Auth\Entity\Admin;
use App\Auth\Services\PasswordHasher;
use App\Flusher;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    private EntityManagerInterface $em;
    private Flusher $flusher;
    private PasswordHasher $hasher;

    public function __construct(EntityManagerInterface $em, Flusher $flusher, PasswordHasher $hasher)
    {
        $this->em = $em;
        $this->flusher = $flusher;
        $this->hasher = $hasher;
    }

    public function handle(Command $command)
    {
        $uinfo = $this->em->getRepository(Admin::Class)->findOneBy(['userName' => $command->username]);
        if ($this->hasher->validate($command->password, $uinfo->getPasswordHash())) {
            return $uinfo;
        }
        return false;
    }
}
