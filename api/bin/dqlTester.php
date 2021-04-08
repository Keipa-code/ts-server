<?php

declare(strict_types=1);

use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use Psr\Container\ContainerInterface;

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../conf/container.php';

$subs = $container->get(SubscriberRepository::class);

$qb = $subs->privateRepo->createQueryBuilder('p');
$data = $qb->select('p')
    ->setFirstResult(0)
    ->setMaxResults(50)
    ->getQuery()->getResult();;
$subs = [];
foreach ($data as $datum) {
    $subs[] = $datum->getInListFormat();
}

var_dump($subs);