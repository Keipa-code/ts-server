<?php

declare(strict_types=1);


namespace App\Admin\Command\AddSubscriber\Request;


use App\Admin\Command\Entity\Subscriber\Id;
use App\Admin\Command\Entity\Subscriber\JuridicalSubscriber;
use App\Admin\Command\Entity\Subscriber\PhoneNumber;
use App\Admin\Command\Entity\Subscriber\PrivateSubscriber;
use DateTimeImmutable;

class Handler
{
    private SubscriberRepository $subscribers;

    public function __construct(SubscriberRepository $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    public function handle(Command $command): void
    {
        $phoneNumber = new PhoneNumber($command->phoneNumber);

        if ($command->subscriberType === 'private'){
            $subscriber = new PrivateSubscriber(
                Id::generate(),
                new DateTimeImmutable(),
                $phoneNumber,
                $command->subscriberType,
                $command->firstname,
                $command->surname,
                $command->patronymic
            );
        }elseif($command->subscriberType === 'juridical'){
            $subscriber = new JuridicalSubscriber(
                Id::generate(),
                new DateTimeImmutable(),
                $phoneNumber,
                $command->subscriberType,
                $command->organizationName,
                $command->departmentName,
                $command->country,
                $command->city,
                $command->street,
                $command->houseNumber,
                $command->floatNumber
            );
        }

        $this->subscribers->add($subscriber);

    }
}