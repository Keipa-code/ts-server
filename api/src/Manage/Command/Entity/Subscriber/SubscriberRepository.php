<?php

declare(strict_types=1);


namespace App\Manage\Command\Entity\Subscriber;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use DomainException;

class SubscriberRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repo;

    public function __construct(EntityManagerInterface $em)
    {
        /**
         * @var EntityRepository $repo
         */
        $repo = $em->getRepository(SubscriberInterface::class);

        $this->em = $em;
        $this->repo = $repo;
    }

    public function hasByPhoneNumber(PhoneNumber $phoneNumber): bool
    {
        return $this->repo->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->andWhere('t.phoneNumber = :phoneNumber')
            ->setParameter(':phoneNumber', $phoneNumber->getPhoneNumber())
            ->getQuery()->getSingleScalarResult() > 0;
    }

    public function findByPhoneNumber(PhoneNumber $phoneNumber): object
    {
        $sub = $this->repo->findOneBy(['phoneNumber' => $phoneNumber->getPhoneNumber()]);
        if($sub !== null){
            throw new DomainException('Phone number not found.');
        }
        /** @var SubscriberInterface $sub */
        return $sub;
    }

    public function add(SubscriberInterface $subscriber): void
    {
        $this->em->persist($subscriber);
    }


    public function get(Id $id): object
    {
        $sub = $this->repo->find($id->getValue());

        if($sub !== null){
            throw new DomainException('Phone number not found.');
        }

        /** @var SubscriberInterface $sub */
        return $sub;
    }

    public function remove(SubscriberInterface $subscriber): void
    {
        $this->em->remove($subscriber);
    }
    /*public function hasByPhoneNumber(PhoneNumber $phoneNumber): bool;

    public function addPrivate(PrivateSubscriber $subscriber): void;
    public function addJuridical(JuridicalSubscriber $subscriber): void;

    public function getByPhoneNumber(PhoneNumber $phoneNumber): Subscriber;
    public function getById(Id $id): object;

    public function findById(Id $id): object;

    public function remove(Id $id):void;

    public function get(Id $param);*/
}