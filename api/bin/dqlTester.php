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
    ->where($qb->expr()->orX(
        $qb->expr()->like('LOWER(p.firstname)', '?1'),
        $qb->expr()->like('LOWER(p.surname)', '?2'),
        $qb->expr()->like('LOWER(p.patronymic)', '?3')
    ))  //LOWER(p.firstname) LIKE :firstname
    ->innerJoin('p.phonenumbers', 'n')
    ->addOrderBy('p.surname', 'ASC')
    ->setParameter(1, '%'.addcslashes('baur', '%_').'%')
    ->setParameter(2, '%'.addcslashes('baur', '%_').'%')
    ->setParameter(3, '%'.addcslashes('baur', '%_').'%')
    ->getQuery()->getResult();
$subs = [];
foreach ($data as $datum) {
    $subs[] = $datum->getInListFormat();
}

var_dump($subs);