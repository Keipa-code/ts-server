<?php

declare(strict_types=1);

namespace App\Manage\Command\GetJuridicalList;

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
        if ($command->pageNumber === 1) {
            $offset = 0;
        } elseif ($command->pageNumber > 1) {
            $offset = (int)$command->pageNumber * 50;
        }
        $limit = $command->rowCount;
        $subs = [];

        if (!$command->phonenumber && !$command->organizationName) {
            $juridicalSubs = $this->subscribers->findAllJuridical($offset, $limit);
            foreach ($juridicalSubs as $sub) {
                $subs[] = $sub->getInListFormat();
            }
            return $subs;
        } else {
            if ($command->phonenumber) {
                $foundedPhonenumber = $this->subscribers->findByPhoneNumber(new Phonenumber($command->phonenumber));
                foreach ($foundedPhonenumber as $sub) {
                    $subs[] = $sub->getInListFormat();
                }
                return $subs;
            }
            if ($command->organizationName) {
                if ($command->sort) {
                    $foundedOrgs = $this->subscribers->findByOrgNameWithSort(
                        $command->organizationName,
                        $command->sort,
                        $command->order);
                } else {
                    $foundedOrgs = $this->subscribers->findByOrgName($command->organizationName);
                }

                foreach ($foundedOrgs as $sub) {
                    $subs[] = $sub->getInListFormat();
                }
                return $subs;
            }
        }

        return $subs;

    }
}