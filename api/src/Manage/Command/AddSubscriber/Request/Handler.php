<?php

declare(strict_types=1);


namespace App\Manage\Command\AddSubscriber\Request;


use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\JuridicalSubscriber;
use App\Manage\Command\Entity\Subscriber\PhoneNumber;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use App\Manage\Command\Entity\Subscriber\SubscriberType;
use App\Flusher;
use DateTimeImmutable;
use Webmozart\Assert\Assert;

class Handler
{
    private SubscriberRepository $subscribers;
    private Flusher $flusher;

    public function __construct(SubscriberRepository $subscribers, Flusher $flusher)
    {
        $this->subscribers = $subscribers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $phoneNumber = new PhoneNumber($command->phoneNumber);
        $subscriberType = new SubscriberType($command->subscriberType);

        if($this->subscribers->hasByPhoneNumber($phoneNumber)){
            throw new \DomainException('User already exists.');
        }

        if ($subscriberType->isPrivate()){
            Assert::stringNotEmpty($command->firstname);
            Assert::stringNotEmpty($command->surname);
            Assert::stringNotEmpty($command->patronymic);
            $subscriber = new PrivateSubscriber(
                Id::generate(),
                new DateTimeImmutable(),
                $phoneNumber,
                $subscriberType,
                $command->firstname,
                $command->surname,
                $command->patronymic
            );
            $this->subscribers->addPrivate($subscriber);
        }elseif($subscriberType->isJuridical()){
            Assert::stringNotEmpty($command->organizationName);
            Assert::stringNotEmpty($command->departmentName);
            Assert::stringNotEmpty($command->country);
            Assert::stringNotEmpty($command->city);
            Assert::stringNotEmpty($command->street);
            Assert::stringNotEmpty($command->houseNumber);
            Assert::stringNotEmpty($command->floatNumber);
            $subscriber = new JuridicalSubscriber(
                Id::generate(),
                new DateTimeImmutable(),
                $phoneNumber,
                $subscriberType,
                $command->organizationName,
                $command->departmentName,
                $command->country,
                $command->city,
                $command->street,
                $command->houseNumber,
                $command->floatNumber
            );
            $this->subscribers->addJuridical($subscriber);
        }

        $this->flusher->flush();
    }
}