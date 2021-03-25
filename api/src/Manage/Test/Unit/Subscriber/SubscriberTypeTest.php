<?php

declare(strict_types=1);


namespace App\Manage\Test\Unit\Subscriber;


use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\SubscriberType;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @covers SubscriberType
 */
class SubscriberTypeTest extends TestCase
{
    public function testSuccess(): void
    {
        $subscriberType1 = new SubscriberType($value1 = 'private');
        $subscriberType2 = new SubscriberType($value2 = 'juridical');

        self::assertEquals($value1, $subscriberType1->getSubscriberType());
        self::assertEquals($value2, $subscriberType2->getSubscriberType());
    }

    public function testCase(): void
    {
        $value = 'private';

        $subscriberType = new SubscriberType(mb_strtolower($value));

        self::assertEquals($value, $subscriberType->getSubscriberType());
    }

    public function testIsPrivate(): void
    {
        $subscriberType = new SubscriberType('private');

        self::assertEquals(true, $subscriberType->isPrivate());
    }

    public function testIsJuridical(): void
    {
        $subscriberType = new SubscriberType('juridical');

        self::assertEquals(true, $subscriberType->isJuridical());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Id('12345');
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Id('');
    }
}