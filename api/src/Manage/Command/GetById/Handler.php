<?php

declare(strict_types=1);

namespace App\Manage\Command\GetById;

use App\Manage\Command\Entity\Subscriber\Id;
use App\Manage\Command\Entity\Subscriber\SubscriberRepository;

class Handler
{
    private SubscriberRepository $subscribers;

    public function __construct(SubscriberRepository $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    public function handle(Command $command): array
    {
        $id = new Id($command->id);
        $sub = $this->subscribers->get($id);
        return $sub->getInEditFormat();
    }
}
