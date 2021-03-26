<?php

declare(strict_types=1);

namespace App\Manage\Command\Entity\Subscriber;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

class SubscriberCreator
{
    public static function create(
        Id $id,
        PhoneNumber $phoneNumber,
        SubscriberType $subscriberType,
        array $subData
    ): SubscriberInterface {
        /** @psalm-var array{
         *     private:array<array-key, mixed>,
         *     juridical:array<array-key, mixed>
         * } $subData
         */
        if ($subscriberType->isPrivate()) {
            foreach ($subData['private'] as $sub) {
                Assert::stringNotEmpty($sub);
            }
            $subscriber = new PrivateSubscriber(
                $id,
                $phoneNumber,
                new DateTimeImmutable(),
                $subData['private']
            );
        } elseif ($subscriberType->isJuridical()) {
            /** @var string $sub */
            foreach ($subData['juridical'] as $key => $sub) {
                if ($key = 'floatNumber') {
                    break;
                }
                Assert::stringNotEmpty($sub);
            }
            $subscriber = new JuridicalSubscriber(
                $id,
                $phoneNumber,
                new DateTimeImmutable(),
                $subData['juridical']
            );
        }
        /** @var SubscriberInterface $subscriber */
        return $subscriber;
    }
}
