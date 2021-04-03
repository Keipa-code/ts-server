<?php

declare(strict_types=1);

namespace App\Manage\Command\ListSubscriber\Request;

use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\JuridicalSubscriber;
use App\Manage\Command\Entity\Subscriber\Phonenumber;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
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

    public function handle(Command $command): array
    {
        $offset = (int)$command->pageNumber * 50;
        $limit = $command->rowCount;
        $subscriberType = new SubscriberType($command->subscriberType);
        if ($subscriberType->isPrivate()) {
            return $this->subscribers->findAllPrivate($command->sort, $command->order, $offset, $limit);
        } elseif ($subscriberType->isJuridical()) {
            return $this->subscribers->findAllJuridical($command->sort, $command->order, $offset, $limit);
        }

    }
}
