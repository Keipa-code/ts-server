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
    private EntityRepository $privateRepo;
    private EntityRepository $juridicalRepo;

    public function __construct(EntityManagerInterface $em)
    {
        /**
         * @var EntityRepository $privateRepo
         */
        $privateRepo = $em->getRepository(PrivateSubscriber::class);
        /**
         * @var EntityRepository $juridicalRepo
         */
        $juridicalRepo = $em->getRepository(JuridicalSubscriber::class);
        $this->em = $em;
        $this->privateRepo = $privateRepo;
        $this->juridicalRepo = $juridicalRepo;
    }

    public function hasByPhoneNumber(PhoneNumber $phoneNumber): bool
    {
        $privateSearch = $this->privateRepo->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->andWhere('t.phoneNumber = :phoneNumber')
            ->setParameter(':phoneNumber', $phoneNumber->getValue())
            ->getQuery()->getSingleScalarResult() > 0;
        $juridicalSearch  = $this->privateRepo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.phoneNumber = :phoneNumber')
                ->setParameter(':phoneNumber', $phoneNumber->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
        if($privateSearch === true)
        {
            return true;
        }elseif ($juridicalSearch === true)
        {
            return true;
        }else{
            return false;
        }
    }

    public function findByPhoneNumber(PhoneNumber $phoneNumber): object
    {
        $privateSub = $this->privateRepo->findOneBy(['phoneNumber' => $phoneNumber->getValue()]);
        $juridicalSub = $this->juridicalRepo->findOneBy(['phoneNumber' => $phoneNumber->getValue()]);
        if($privateSub !== null){
            return $privateSub;
        }elseif ($juridicalSub !== null){
            return $juridicalSub;
        }else{
            throw new DomainException('Phone number not found.');
        }
    }

    public function addPrivate(PrivateSubscriber $subscriber): void
    {
        $this->em->persist($subscriber);
    }

    public function addJuridical(JuridicalSubscriber $subscriber): void
    {
        $this->em->persist($subscriber);
    }

    public function get(Id $id): object
    {
        $privateSub = $this->privateRepo->find($id->getValue());
        $juridicalSub = $this->juridicalRepo->find($id->getValue());
        if($privateSub !== null){
            return $privateSub;
        }elseif ($juridicalSub !== null){
            return $juridicalSub;
        }else{
            throw new DomainException('Subscriber number not found.');
        }
    }

    public function remove(object $subscriber): void
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