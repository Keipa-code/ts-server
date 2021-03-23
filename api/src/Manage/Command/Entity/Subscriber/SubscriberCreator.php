<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use DateTimeImmutable;
use Webmozart\Assert\Assert;

class SubscriberCreator
{
    public static function create(
        $id,
        $subscriberType,
        $subData
    )
    {
        if ($subscriberType->isPrivate()) {
            foreach ($subData['private'] as $sub) {
                Assert::stringNotEmpty($sub);
            }
            $subscriber = new PrivateSubscriber(
                $id,
                new DateTimeImmutable(),
                $subData['private']
            );
        }
        elseif ($subscriberType->isJuridical()) {
            foreach ($subData['juridical'] as $key => $sub) {
                if ($key = 'floatNumber') {
                    break;
                }
                Assert::stringNotEmpty($sub);
            }
            $subscriber = new JuridicalSubscriber(
                $id,
                new DateTimeImmutable(),
                $subData['juridical']
            );
        }
        /** @var SubscriberInterface $subscriber */
        return $subscriber;
    }
}