<?php

declare(strict_types=1);

use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use Psr\Container\ContainerInterface;

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../conf/container.php';

$subs = $container->get(SubscriberRepository::class);

$em = $subs->getEm();

$fio = '7770000006';
$qb = $subs->privateRepo->createQueryBuilder('p');
$data = $qb->select('p')
    ->innerJoin('p.phonenumbers', 'n')
    ->andWhere($qb->expr()->like('n.phonenumber.number', '?1'))
    ->setParameter(1, '%' . addcslashes($fio, '%_') . '%')
    ->getQuery()->getResult();

    $subs = [];
foreach ($data as $datum) {
    $subs[] = $datum->getInListFormat();
}

var_dump($subs);
