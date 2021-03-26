<?php

declare(strict_types=1);

use App\Manage\Command\Entity\Subscriber\JuridicalSubscriber;
use App\Manage\Command\Entity\Subscriber\PrivateSubscriber;
use App\Manage\Command\Entity\Subscriber\SubscriberInterface;
use App\Manage\Command\Entity\Subscriber\SubscriberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

return [
    SubscriberRepository::class => function (ContainerInterface $container): SubscriberRepository {
        $em = $container->get(EntityManagerInterface::class);
        /**
         * @var EntityRepository $repo
         */
        $privateRepo = $em->getRepository(PrivateSubscriber::class);
        $juridicalRepo = $em->getRepository(JuridicalSubscriber::class);
        return new SubscriberRepository($em, $privateRepo, $juridicalRepo);
    }
];
