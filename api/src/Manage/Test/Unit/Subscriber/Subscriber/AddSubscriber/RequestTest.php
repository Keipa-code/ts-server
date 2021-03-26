<?php

declare(strict_types=1);

namespace App\Manage\Command\Entity\Subscriber\Subscriber\AddSubscriber;

use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\JuridicalSubscriber;
use App\Manage\Command\Entity\Subscriber\Phonenumber;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
use App\Manage\Command\Entity\Subscriber\SubscriberType;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @covers Subscriber
 */
class RequestTest extends TestCase
{
    public function testSuccessPrivate(): void
    {
        $subscriber = new PrivateSubscriber(
            $id = Id::generate(),
            $phoneNumber = new Phonenumber('77075554444', new SubscriberType('private')),
            $date = new DateTimeImmutable(),
            $subData = [
                'firstname' => 'Baur',
                'surname' => 'Shuak',
                'patronymic' => 'Semba',
            ],
        );

        self::assertEquals($id, $subscriber->getId());
        self::assertEquals($date, $subscriber->getDate());
        self::assertIsArray($subscriber->getPhonenumbers());
        self::assertEquals($subData['firstname'], $subscriber->getFirstname());
        self::assertEquals($subData['surname'], $subscriber->getSurname());
        self::assertEquals($subData['patronymic'], $subscriber->getPatronymic());
    }

    public function testSuccessJuridical(): void
    {
        $subscriber = new JuridicalSubscriber(
            $id = Id::generate(),
            $phoneNumber = new Phonenumber('77075554444', new SubscriberType('private')),
            $date = new DateTimeImmutable(),
            $subData = [
                'organizationName' => 'Uniserv',
                'departmentName' => 'priemnaya',
                'country' => 'Kazakstan',
                'city' => 'Oral',
                'street' => 'Amana',
                'houseNumber' => '62A',
                'floatNumber' => '41',
            ],
        );

        self::assertEquals($id, $subscriber->getId());
        self::assertEquals($date, $subscriber->getDate());
        self::assertIsArray($subscriber->getPhonenumbers());
        self::assertEquals($subData['organizationName'], $subscriber->getOrganizationName());
        self::assertEquals($subData['country'], $subscriber->getCountry());
        self::assertEquals($subData['city'], $subscriber->getCity());
        self::assertEquals($subData['street'], $subscriber->getStreet());
        self::assertEquals($subData['houseNumber'], $subscriber->getHouseNumber());
        self::assertEquals($subData['floatNumber'], $subscriber->getFloatNumber());
    }
}
