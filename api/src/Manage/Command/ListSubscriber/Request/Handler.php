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
        $subs = [];

        if (!$command->phonenumber && !$command->organizationName && !$command->fio) {
            if ($subscriberType->isPrivate()) {
                $privateSubs = $this->subscribers->findAllPrivate($command->sort, $command->order, $offset, $limit);
                foreach ($privateSubs as $sub) {
                    $subs[] = $sub->getInListFormat();
                }
            } elseif ($subscriberType->isJuridical()) {
                $juridicalSubs = $this->subscribers->findAllJuridical($command->sort, $command->order, $offset, $limit);
                foreach ($juridicalSubs as $sub) {
                    $subs[] = $sub->getInListFormat();
                }
            }
        }else {
            if ($command->fio) {

                $foundedFIO = $this->subscribers->findByFIO($command->fio);
                foreach ($foundedFIO as $sub) {
                    $subs[] = $sub->getInListFormat();
                }
            }
            if ($command->phonenumber) {
                $foundedPhonenumber = $this->subscribers->findByPhoneNumber(new Phonenumber($command->phonenumber));
                foreach ($foundedPhonenumber as $sub) {
                    $subs[] = $sub->getInListFormat();
                }
            }
            if ($command->organizationName) {
                $foundedOrgs = $this->subscribers->findByOrgName($command->organizationName);
                foreach ($foundedOrgs as $sub) {
                    $subs[] = $sub->getInListFormat();
                }
            }
        }

        return $subs;

    }
}
