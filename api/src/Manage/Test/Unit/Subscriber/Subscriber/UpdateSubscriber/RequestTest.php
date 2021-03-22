<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber\Subscriber\UpdateSubscriber;


use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\JuridicalSubscriber;
use App\Manage\Command\Entity\Subscriber\PhoneNumber;
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
            $date = new DateTimeImmutable(),
            $phoneNumber = new PhoneNumber('77075554444'),
            $subscriberType = new SubscriberType('private'),
            $firstname = 'Baur',
            $surname = 'Shuak',
            $patronymic = 'Semauli'
        );

        $subscriber->updateSubscriber(
            $newPhoneNumber = new PhoneNumber('77074445555'),
            $newSubscriberType = new SubscriberType('private'),
            $newFirstname = 'Nadya',
            $newSurname = 'Khan',
            $newPatronymic = 'Roman'
        );

        self::assertEquals($id, $subscriber->getId());
        self::assertNotEquals($date, $subscriber->getDate());
        self::assertEquals($newPhoneNumber, $subscriber->getPhoneNumber());
        self::assertEquals($newSubscriberType, $subscriber->getSubscriberType());
        self::assertEquals($newFirstname, $subscriber->getFirstname());
        self::assertEquals($newSurname, $subscriber->getSurname());
        self::assertEquals($newPatronymic, $subscriber->getPatronymic());
    }

    public function testSuccessJuridical(): void
    {
        $subscriber = new JuridicalSubscriber(
            $id = Id::generate(),
            $date = new DateTimeImmutable(),
            $phoneNumber = new PhoneNumber('77075554444'),
            $subscriberType = new SubscriberType('juridical'),
            $organizationName = 'Uniserv',
            $departmentName = 'priemnaya',
            $country = 'Kazakstan',
            $city = 'Oral',
            $street = 'Amana',
            $houseNumber = '62A',
            $floatNumber = '41'
        );

        $subscriber->updateSubscriber(
            $newPhoneNumber = new PhoneNumber('77074445555'),
            $newSubscriberType = new SubscriberType('juridical'),
            $newOrganizationName = 'Aqjayk',
            $newDepartmentName = 'dizainer',
            $newCountry = 'Qazaqstan',
            $newCity = 'Uralsk',
            $newStreet = 'Sdykova',
            $newHouseNumber = '1/1',
            $newFloatNumber = '1'
        );

        self::assertEquals($id, $subscriber->getId());
        self::assertNotEquals($date, $subscriber->getDate());
        self::assertEquals($newPhoneNumber, $subscriber->getPhoneNumber());
        self::assertEquals($newSubscriberType, $subscriber->getSubscriberType());
        self::assertEquals($newOrganizationName, $subscriber->getOrganizationName());
        self::assertEquals($newDepartmentName, $subscriber->getDepartmentName());
        self::assertEquals($newCountry, $subscriber->getCountry());
        self::assertEquals($newCity, $subscriber->getCity());
        self::assertEquals($newStreet, $subscriber->getStreet());
        self::assertEquals($newHouseNumber, $subscriber->getHouseNumber());
        self::assertEquals($newFloatNumber, $subscriber->getFloatNumber());
    }
}