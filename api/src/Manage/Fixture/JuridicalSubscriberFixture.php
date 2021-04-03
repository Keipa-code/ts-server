<?php

declare(strict_types=1);

namespace App\Manage\Fixture;

use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\Phonenumber;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
use App\Manage\Command\Entity\Subscriber\SubscriberCreator;
use App\Manage\Command\Entity\Subscriber\SubscriberType;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class JuridicalSubscriberFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $subscriberType = new SubscriberType('juridical');
        $phoneNumber = new Phonenumber('7770000002');
        $juridicalSub = SubscriberCreator::create(
            new Id('00000000-0000-0000-0000-000000000002'),
            $phoneNumber,
            $subscriberType,
            $data = [
                'organizationName' => 'uniserv',
                'departmentName' => 'priemnaya',
                'country' => 'RK',
                'city' => 'oral',
                'street' => 'nurmanova',
                'houseNumber' => '10/1'
            ]
        );

        $manager->persist($juridicalSub);

        $manager->flush();
    }
}
