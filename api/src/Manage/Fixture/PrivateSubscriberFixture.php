<?php

declare(strict_types=1);


namespace App\Manage\Fixture;


use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\PhoneNumber;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
use App\Manage\Command\Entity\Subscriber\SubscriberCreator;
use App\Manage\Command\Entity\Subscriber\SubscriberType;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class PrivateSubscriberFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $subscriberType = new SubscriberType('private');
        $phoneNumber = new PhoneNumber('7770000001', $subscriberType);
        $privateSub = SubscriberCreator::create(
            new Id('00000000-0000-0000-0000-000000000001'),
            $phoneNumber,
            $subscriberType,
            $data = [
                'private' => [
                    'firstname' => 'Baur',
                    'surname' => 'Shuak',
                    'patronymic' => 'Semba']]
        );

        $manager->persist($privateSub);

        $manager->flush();
    }
}