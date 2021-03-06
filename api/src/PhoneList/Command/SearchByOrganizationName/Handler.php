<?php

declare(strict_types=1);

namespace App\PhoneList\Command\SearchByOrganizationName;

use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use Psr\Log\LoggerInterface;
use Webmozart\Assert\Assert;

class Handler
{

    private SubscriberRepository $subscribers;

    public function __construct(SubscriberRepository $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    public function handle(Command $command, LoggerInterface $logger)
    {
        Assert::stringNotEmpty($command->organizationName);

        $foundedSubs =  $this->subscribers->findByOrgName($command->organizationName);
        $subs = [];
        foreach ($foundedSubs as $sub) {
            $subs[] = $sub->getInListFormat();
        }
        return $subs;
    }
}
