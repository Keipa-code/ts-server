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
use Faker\Factory;

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

        $faker = Factory::create('ru_RU');
        for ($j = 0; $j < 500; $j++) {
            $subscriberType = new SubscriberType('juridical');
            $phoneNumber = new Phonenumber($faker->phoneNumber);
            $juridicalSub = SubscriberCreator::create(
                Id::generate(),
                $phoneNumber,
                $subscriberType,
                $data = [
                    'organizationName' => $faker->company,
                    'departmentName' => $faker->jobTitle,
                    'country' => $faker->country,
                    'city' => $faker->city,
                    'street' => $faker->streetName,
                    'houseNumber' => $faker->buildingNumber,
                    'floatNumber' => $faker->buildingNumber
                ]
            );

            $manager->persist($juridicalSub);

            $manager->flush();
        }
    }
}
