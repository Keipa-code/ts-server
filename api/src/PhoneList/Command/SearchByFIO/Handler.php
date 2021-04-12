<?php

declare(strict_types=1);

namespace App\PhoneList\Command\SearchByFIO;

use App\Manage\Command\Entity\Subscriber\Phonenumber;
use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use InvalidArgumentException;
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
        if ($command->pageNumber === 1) {
            $offset = 0;
        } elseif ($command->pageNumber > 1) {
            $offset = $command->pageNumber * 50;
        } else {
            throw new InvalidArgumentException('Invalid page number');
        }
        $subs = [];
        if (!$command->phonenumber && !$command->fio && !$command->organizationName) {
            if (!$command->sort) {
                $privateSubs = $this->subscribers->findAllPrivate($offset, $command->rowCount);
            } else {
                $command->sort = 'p.surname';
                $privateSubs = $this->subscribers->findAllPrivateWithSort(
                    $command->sort,
                    $command->order,
                    $offset,
                    $command->rowCount
                );
            }
            foreach ($privateSubs as $sub) {
                $subs[] = $sub->getInListFormat();
            }
            return $subs;
        }
        if ($command->fio) {
            if ($command->sort) {
                $command->sort = 'p.surname';
                $foundedFIO = $this->subscribers->findByFIOWithSort($command->fio, $command->sort, $command->order, $offset, $command->rowCount);
            } else {
                $foundedFIO = $this->subscribers->findByFIO($command->fio, $offset, $command->rowCount);
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
                    $command->order,
                    $offset,
                    $command->rowCount
                );
            } else {
                $foundedOrgs = $this->subscribers->findByOrgName($command->organizationName, $offset, $command->rowCount);
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
