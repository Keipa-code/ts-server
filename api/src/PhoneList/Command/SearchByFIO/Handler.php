<?php

declare(strict_types=1);


namespace App\PhoneList\Command\SearchByFIO;


use App\Manage\Command\Entity\Subscriber\Phonenumber;
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

    public function handle(Command $command, LoggerInterface $logger): array
    {
        $subs = [];
        if ($command->fio) {
            if ($command->sort) {
                $command->sort = 'p.surname';
                $foundedFIO = $this->subscribers->findByFIOWithSort($command->fio, $command->sort, $command->order);
            }else {
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
        if ($command->organizationName) {
            if ($command->sort) {
                $command->sort = 'p.organizationName';
                $foundedOrgs = $this->subscribers->findByOrgNameWithSort(
                    $command->organizationName,
                    $command->sort,
                    $command->order);
            }else {
                $foundedOrgs = $this->subscribers->findByOrgName($command->organizationName);
            }

            foreach ($foundedOrgs as $sub) {
                $subs[] = $sub->getInListFormat();
            }
            return $subs;
        }
        //$logger->warning($this->subscribers->getCountOfAll());
        return $subs;
    }
}