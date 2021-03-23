<?php

declare(strict_types=1);


namespace App\Manage\Test\Unit\Subscriber;


use App\Manage\Command\Entity\Subscriber\PhoneNumber;
use libphonenumber\NumberParseException;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;


/**
 * @covers PhoneNumber
 */
class PhoneNumberTest extends TestCase
{
    public function testSuccess(): void
    {
        $phoneNumber = new PhoneNumber($value = '7075554444');

        self::assertEquals($value, $phoneNumber->getPhoneNumber());
    }

    public function testFormat(): void
    {
        $phoneNumber = new PhoneNumber($value = '8 707 555-4444');

        self::assertEquals('7075554444', $phoneNumber->getPhoneNumber());
    }

    public function testIncorrect(): void
    {
        $this->expectOutputString('The string supplied did not seem to be a phone number.');
        new PhoneNumber($value = 'not phone number');
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new PhoneNumber('');
    }
}