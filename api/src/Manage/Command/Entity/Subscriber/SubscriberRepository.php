<?php

declare(strict_types=1);

namespace App\Manage\Command\Entity\Subscriber;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

class SubscriberRepository
{
    private EntityManagerInterface $em;
    /**
     * @var EntityRepository $privateRepo
     */
    private EntityRepository $privateRepo;
    /**
     * @var EntityRepository $juridicalRepo
     */
    private EntityRepository $juridicalRepo;

    /**
     * @param EntityManagerInterface $em
     * @param EntityRepository $privateRepo
     * @param EntityRepository $juridicalRepo
     */
    public function __construct(EntityManagerInterface $em, EntityRepository $privateRepo, EntityRepository $juridicalRepo)
    {
        $this->em = $em;
        $this->privateRepo = $privateRepo;
        $this->juridicalRepo = $juridicalRepo;
    }

    public function hasByPhoneNumber(Phonenumber $phoneNumber): bool
    {
        $privateSearch = $this->privateRepo->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->innerJoin('t.phonenumbers', 'n')
            ->andWhere('n.phonenumber.number = :phonenumber')
            ->setParameter(':phonenumber', $phoneNumber->getNumber())
            ->getQuery()->getSingleScalarResult() > 0;
        $juridicalSearch = $this->juridicalRepo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->innerJoin('t.phonenumbers', 'n')
                ->andWhere('n.phonenumber.number = :phonenumber')
                ->setParameter(':phonenumber', $phoneNumber->getNumber())
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

    public function findByPhoneNumber(Phonenumber $phoneNumber): object
    {
        $sub = $this->privateRepo->findOneBy(['phoneNumber' => $phoneNumber->getNumber()]);
        if ($sub !== null) {
            throw new DomainException('Phone number not found.');
        }
        /** @var SubscriberInterface $sub */
        return $sub;
    }

    public function add(object $subscriber): void
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
        }else {
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
