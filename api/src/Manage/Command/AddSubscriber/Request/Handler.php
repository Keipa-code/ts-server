<?php

declare(strict_types=1);

namespace App\Manage\Command\AddSubscriber\Request;

use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\JuridicalSubscriber;
use App\Manage\Command\Entity\Subscriber\Phonenumber;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
use App\Manage\Command\Entity\Subscriber\SubscriberCreator;
use App\Manage\Command\Entity\Subscriber\SubscriberInterface;
use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use App\Manage\Command\Entity\Subscriber\SubscriberType;
use App\Flusher;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use Webmozart\Assert\Assert;

class Handler
{
    private SubscriberRepository $subscribers;
    private Flusher $flusher;
    private LoggerInterface $logger;

    public function __construct(SubscriberRepository $subscribers, Flusher $flusher)
    {
        $this->subscribers = $subscribers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $subscriberType = new SubscriberType($command->subscriberType);

        $phoneNumber = new Phonenumber($command->phoneNumber, $subscriberType);

        if ($this->subscribers->hasByPhoneNumber($phoneNumber)) {
            throw new \DomainException('Phone number already exists.');
        }
        $this->logger->critical('ya tuta' . $command->subData['private']['firstname']);
        $id = Id::generate();

        $subscriber = SubscriberCreator::create(
            $id,
            $phoneNumber,
            $subscriberType,
            $command->subData
        );


        $this->subscribers->add($subscriber);

        $this->flusher->flush();
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
