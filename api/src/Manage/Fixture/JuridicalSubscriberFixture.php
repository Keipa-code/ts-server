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

class JuridicalSubscriberFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $subscriberType = new SubscriberType('juridical');
        $phoneNumber = new PhoneNumber('7770000002', $subscriberType);
        $juridicalSub = SubscriberCreator::create(
            new Id('00000000-0000-0000-0000-000000000002'),
            $phoneNumber,
            $subscriberType,
            $data = [
                'juridical' => [
                    'organizationName' => 'uniserv',
                    'departmentName' => 'priemnaya',
                    'country' => 'RK',
                    'city' => 'oral',
                    'street' => 'nurmanova',
                    'houseNumber' => '10/1'
                    ]]
        );

        $manager->persist($juridicalSub);

        $manager->flush();
    }
}