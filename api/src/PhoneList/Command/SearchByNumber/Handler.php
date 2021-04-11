<?php

declare(strict_types=1);

namespace App\PhoneList\Command\SearchByNumber;

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

    public function handle(Command $command, LoggerInterface $logger)
    {
        $phonenumber = new Phonenumber($command->phonenumber);
        $data = $this->subscribers->findByPhoneNumber($phonenumber);
        //$filename = 'array.txt';
        //file_put_contents($filename, serialize($data));
        //$logger->warning(json_encode($data));
        $row = [
            'phonenumber' => $phonenumber->getFormattedNumber(),
            'rowValue' => '' /*$data['0']['firstname']. ' ' .
            $data['0']['surname']. ' ' .
            $data['0']['patronymic']*/
        ];

        foreach ($data['0'] as $datum) {
            $row['rowValue'] .= ' ' . $datum;
        }
        //$logger->warning($row['rowValue']);
        $row['rowValue'] = trim($row['rowValue']);
        return $row;
    }
}
