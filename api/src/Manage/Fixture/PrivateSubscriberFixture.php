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

class PrivateSubscriberFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $subscriberType = new SubscriberType('private');
        $phoneNumber = new Phonenumber('7770000006');
        $privateSub = SubscriberCreator::create(
            new Id('00000000-0000-0000-0000-000000000001'),
            $phoneNumber,
            $subscriberType,
            $data = [
                'firstname' => 'Baur',
                'surname' => 'Shuak',
                'patronymic' => 'Semba']
        );

        $manager->persist($privateSub);

        $manager->flush();

        $subscriberType = new SubscriberType('private');
        $phoneNumber = new Phonenumber('7770000007');
        $privateSub = SubscriberCreator::create(
            Id::generate(),
            $phoneNumber,
            $subscriberType,
            $data = [
                'firstname' => 'Baur',
                'surname' => 'Dosan',
                'patronymic' => 'Tastan']
        );

        $manager->persist($privateSub);

        $manager->flush();

        $subscriberType = new SubscriberType('private');
        $phoneNumber = new Phonenumber('7770000008');
        $privateSub = SubscriberCreator::create(
            Id::generate(),
            $phoneNumber,
            $subscriberType,
            $data = [
                'firstname' => 'Baur',
                'surname' => 'Roman',
                'patronymic' => 'Stalin']
        );

        $manager->persist($privateSub);

        $manager->flush();

        //Faker
        $faker = Factory::create('ru_RU');
        for ($j = 0; $j < 500; $j++) {
            $subscriberType = new SubscriberType('private');
            $phoneNumber = new Phonenumber($faker->phoneNumber);
            $privateSub = SubscriberCreator::create(
                Id::generate(),
                $phoneNumber,
                $subscriberType,
                $data = [
                    'firstname' => $faker->firstName,
                    'surname' => $faker->lastName,
                    'patronymic' => $faker->middleName,
                ]
            );

            $manager->persist($privateSub);

            $manager->flush();
        }
    }
}
