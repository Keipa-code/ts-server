<?php

declare(strict_types=1);

namespace Test\Functional\V1\Manage\Update;

use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\Phonenumber;
use App\Manage\Command\Entity\Subscriber\SubscriberCreator;
use App\Manage\Command\Entity\Subscriber\SubscriberType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class RequestFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $subscriberType = new SubscriberType('juridical');
        $phoneNumber = new Phonenumber('7770000001');
        $juridicalSub = SubscriberCreator::create(
            new Id('00000000-0000-0000-0000-000000000001'),
            $phoneNumber,
            $subscriberType,
            $data = [
                'organizationName' => 'Uniserv',
                'departmentName' => 'priemnaya',
                'country' => 'Kaz',
                'city' => 'Oral',
                'street' => 'Nekrasova',
                'houseNumber' => '14',
                'floatNumber' => '',
                ]
        );

        $manager->persist($juridicalSub);

        $manager->flush();

        $subscriberType = new SubscriberType('private');
        $phoneNumber = new Phonenumber('7770000003');
        $privateSub = SubscriberCreator::create(
            new Id('00000000-0000-0000-0000-000000000003'),
            $phoneNumber,
            $subscriberType,
            $data = [
                'firstname' => 'Ivan',
                'surname' => 'Ivanov',
                'patronymic' => 'Ivanovich',
            ]
        );

        $manager->persist($privateSub);

        $manager->flush();
    }
}
