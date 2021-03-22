<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber\Subscriber\AddSubscriber;


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

        self::assertEquals($id, $subscriber->getId());
        self::assertEquals($date, $subscriber->getDate());
        self::assertEquals($phoneNumber, $subscriber->getPhoneNumber());
        self::assertEquals($subscriberType, $subscriber->getSubscriberType());
        self::assertEquals($firstname, $subscriber->getFirstname());
        self::assertEquals($surname, $subscriber->getSurname());
        self::assertEquals($patronymic, $subscriber->getPatronymic());
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

        self::assertEquals($id, $subscriber->getId());
        self::assertEquals($date, $subscriber->getDate());
        self::assertEquals($phoneNumber, $subscriber->getPhoneNumber());
        self::assertEquals($subscriberType, $subscriber->getSubscriberType());
        self::assertEquals($organizationName, $subscriber->getOrganizationName());
        self::assertEquals($departmentName, $subscriber->getDepartmentName());
        self::assertEquals($country, $subscriber->getCountry());
        self::assertEquals($city, $subscriber->getCity());
        self::assertEquals($street, $subscriber->getStreet());
        self::assertEquals($houseNumber, $subscriber->getHouseNumber());
        self::assertEquals($floatNumber, $subscriber->getFloatNumber());
    }
}