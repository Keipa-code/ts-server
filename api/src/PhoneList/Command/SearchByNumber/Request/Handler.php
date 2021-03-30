<?php

declare(strict_types=1);


namespace App\PhoneList\Command\SearchByNumber\Request;


use App\Manage\Command\Entity\Subscriber\SubscriberRepository;

class Handler
{

    private SubscriberRepository $subscribers;

    public function __construct(SubscriberRepository $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    public function handle(Command $command)
    {
        $
        $this->subscribers->findByPhoneNumber($command->phonenumber);
    }
}