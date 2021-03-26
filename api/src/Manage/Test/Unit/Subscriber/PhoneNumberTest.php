<?php

declare(strict_types=1);

namespace App\Manage\Test\Unit\Subscriber;

use App\Manage\Command\Entity\Subscriber\Phonenumber;
use App\Manage\Command\Entity\Subscriber\SubscriberType;
use InvalidArgumentException;
use libphonenumber\NumberParseException;
use PHPUnit\Framework\TestCase;

/**
 * @covers Phonenumber
 */
class PhoneNumberTest extends TestCase
{
    public function testSuccess(): void
    {
        $subscriberType = new SubscriberType('private');
        $phoneNumber = new Phonenumber($value = '7075554444', $subscriberType);

        self::assertEquals($value, $phoneNumber->getNumber());
    }

    public function testFormat(): void
    {
        $subscriberType = new SubscriberType('private');
        $phoneNumber = new Phonenumber($value = '8 707 555-4444', $subscriberType);

        self::assertEquals('7075554444', $phoneNumber->getNumber());
    }

    public function testIncorrect(): void
    {
        $subscriberType = new SubscriberType('private');
        $this->expectException(NumberParseException::class);
        new Phonenumber($value = 'not phone number', $subscriberType);
    }

    public function testEmpty(): void
    {
        $subscriberType = new SubscriberType('private');
        $this->expectException(InvalidArgumentException::class);
        new Phonenumber('', $subscriberType);
    }
}
