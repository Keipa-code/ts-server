<?php

declare(strict_types=1);

namespace App\Manage\Command\GetPrivateList;

use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\JuridicalSubscriber;
use App\Manage\Command\Entity\Subscriber\Phonenumber;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
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

    public function __construct(SubscriberRepository $subscribers, Flusher $flusher)
    {
        $this->subscribers = $subscribers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command, LoggerInterface $logger): array
    {
        if ($command->pageNumber === 1) {
            $offset = 0;
        } elseif ($command->pageNumber > 1) {
            $offset = (int)$command->pageNumber * 50;
        }
        $limit = $command->rowCount;
        //$subscriberType = new SubscriberType($command->subscriberType);
        $subs = [];

        if (!$command->phonenumber && !$command->fio) {
                $privateSubs = $this->subscribers->findAllPrivate($offset, $limit);
            foreach ($privateSubs as $sub) {
                $subs[] = $sub->getInListFormat();
            }
                return $subs;
        } else {
            if ($command->fio) {
                if ($command->sort) {
                    $foundedFIO = $this->subscribers->findByFIOWithSort($command->fio, $command->sort, $command->order);
                } else {
                    $foundedFIO = $this->subscribers->findByFIO($command->fio);
                }
                foreach ($foundedFIO as $sub) {
                    $subs[] = $sub->getInListFormat();
                }
                return $subs;
            }
            if ($command->phonenumber) {
                $foundedPhonenumber = $this->subscribers->findByPhoneNumber(new Phonenumber($command->phonenumber));
                foreach ($foundedPhonenumber as $sub) {
                    $subs[] = $sub->getInListFormat();
                }
                return $subs;
            }
        }

        return $subs;
    }
}
