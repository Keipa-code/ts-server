<?php

declare(strict_types=1);

use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use Psr\Container\ContainerInterface;

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../conf/container.php';

$subs = $container->get(SubscriberRepository::class);

$qb = $subs->privateRepo->createQueryBuilder('p');
$data = $qb->select('p, j')
    ->from('App\Manage\Command\Entity\Subscriber\JuridicalSubscriber', 'j')
    ->where($qb->expr()->orX(
        $qb->expr()->eq('p.id', '?2'),
        $qb->expr()->eq('j.id', '?1')
    ))  //LOWER(p.firstname) LIKE :firstname
    ->setParameter(1, '00000000-0000-0000-0000-000000000002')
    ->setParameter(2, '797fc191-4479-4600-b9e5-11a8728dfa21')
    ->getQuery()->getResult();

    $subs = [];
foreach ($data as $datum) {
    $subs[] = $datum->getInListFormat();
}

var_dump($subs);
