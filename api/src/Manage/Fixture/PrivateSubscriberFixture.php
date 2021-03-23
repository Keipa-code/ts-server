<?php

declare(strict_types=1);


namespace App\Manage\Fixture;


use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\PhoneNumber;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
use App\Manage\Command\Entity\Subscriber\SubscriberType;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class PrivateSubscriberFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $privateSub = new PrivateSubscriber(
            new Id('00000000-0000-0000-0000-000000000001'),
            $date = new DateTimeImmutable('-30 days'),
            $phoneNumber = new PhoneNumber('7770000001'),
            $subscriberType = new SubscriberType('private'),
            'Baur',
            'Shuak',
            'Semba'
        );

        $manager->persist($privateSub);

        $manager->flush();
    }
}