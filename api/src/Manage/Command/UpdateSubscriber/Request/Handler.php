<?php

declare(strict_types=1);


namespace App\Manage\Command\UpdateSubscriber\Request;


use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\JuridicalSubscriber;
use App\Manage\Command\Entity\Subscriber\PhoneNumber;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
use App\Manage\Command\Entity\Subscriber\SubscriberCreator;
use App\Manage\Command\Entity\Subscriber\SubscriberInterface;
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
        $id = new Id($command->id);
        $subscriberType = new SubscriberType($command->subscriberType);
        $phoneNumber = new PhoneNumber($command->phoneNumber, $subscriberType);

        $subscriber = $this->subscribers->get($id);

        $id->setValue($subscriber->getId());
        if(!in_array($phoneNumber->getPhoneNumber(), $subscriber->getPhoneNumbers())) {
            if ($this->subscribers->hasByPhoneNumber($phoneNumber)) {
                throw new \DomainException('Number already exists.');
            }
        }

        $newSubscriber = SubscriberCreator::create(
            $id,
            $subscriberType,
            $command
        );

        /**
         * @var SubscriberInterface $newSubscriber
         */
        $this->subscribers->add($newSubscriber);

        $this->flusher->flush();
    }
}