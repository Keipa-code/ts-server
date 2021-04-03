<?php

declare(strict_types=1);

namespace Test\Functional\V1\PhoneList\SearchByFIO;

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
        $subscriberType = new SubscriberType('private');
        $phoneNumber = new Phonenumber('7770000005');
        $privateSub = SubscriberCreator::create(
            Id::generate(),
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
        $phoneNumber = new Phonenumber('7770000006');
        $privateSub = SubscriberCreator::create(
            Id::generate(),
            $phoneNumber,
            $subscriberType,
            $data = [
                'firstname' => 'Baur',
                'surname' => 'Awar',
                'patronymic' => 'Duma']
        );

        $manager->persist($privateSub);

        $manager->flush();
    }
}
