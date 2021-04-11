<?php

namespace App\PhoneList\Command\GetPageCount;

use App\Manage\Command\Entity\Subscriber\SubscriberRepository;

class Handler
{

    private SubscriberRepository $subscribers;

    public function __construct(SubscriberRepository $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    public function handlePrivate(): int
    {
        return $this->subscribers->getPrivateCount();
    }

    public function handleJuridical(): int
    {
        return $this->subscribers->getJuridicalCount();
    }

    public function handleByFIO($fio): int
    {
        return $this->subscribers->getPrivateCountWithSearch($fio);
    }

    public function handleByOrgName($orgName): int
    {
        return $this->subscribers->getJuridicalCountWithSearch($orgName);
    }
}
