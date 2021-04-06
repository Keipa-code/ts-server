<?php


namespace App\PhoneList\Command\GetAllNumberCount;


use App\Manage\Command\Entity\Subscriber\SubscriberRepository;

class Handler
{

    private SubscriberRepository $subscribers;

    public function __construct(SubscriberRepository $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    public function handle()
    {
        return $this->subscribers->getCountOfAll();
    }
}