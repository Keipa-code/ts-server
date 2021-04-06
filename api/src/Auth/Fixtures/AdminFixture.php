<?php

declare(strict_types=1);


namespace App\Auth\Fixtures;


use App\Auth\Entity\Admin;
use App\Auth\Services\PasswordHasher;
use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\Phonenumber;
use App\Manage\Command\Entity\Subscriber\SubscriberCreator;
use App\Manage\Command\Entity\Subscriber\SubscriberType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $password = new PasswordHasher();
        $admin = new Admin(Id::generate(), 'root', $password->hash('Dimoooon'));

        $manager->persist($admin);

        $manager->flush();
    }
}
