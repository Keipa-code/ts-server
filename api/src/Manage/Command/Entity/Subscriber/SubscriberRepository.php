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
    public function __construct(
        EntityManagerInterface $em,
        EntityRepository $privateRepo,
        EntityRepository $juridicalRepo
    )
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
        if ($privateSearch === true) {
            return true;
        } elseif ($juridicalSearch === true) {
            return true;
        } else {
            return false;
        }
    }

    public function findByPhoneNumber(Phonenumber $phoneNumber): array
    {
        $privateNumber = $this->privateRepo->createQueryBuilder('p')
                ->select('p.firstname, p.surname, p.patronymic')
                ->innerJoin('p.phonenumbers', 'n')
                ->andWhere('n.phonenumber.number = :phonenumber')
                ->setParameter(':phonenumber', $phoneNumber->getNumber())
                ->getQuery()->getArrayResult();
        $juridicalNumber = $this->juridicalRepo->createQueryBuilder('j')
            ->select('j.organizationName, j.departmentName, j.country, j.city, j.street, j.houseNumber, j.floatNumber')
            ->innerJoin('j.phonenumbers', 'n')
            ->andWhere('n.phonenumber.number = :phonenumber')
            ->setParameter(':phonenumber', $phoneNumber->getNumber())
            ->getQuery()->getArrayResult();
        if ($privateNumber) {
            return $privateNumber;
        }elseif ($juridicalNumber) {
            return $juridicalNumber;
        }else{
            return [null];
        }
    }

    public function findByFIO($fio): array
    {
         //$this->privateRepo->findBy(['firstname' => $fio]);
        $qb = $this->privateRepo->createQueryBuilder('p');
        return $qb->select('p')
            ->where($qb->expr()->orX(
                $qb->expr()->like('LOWER(p.firstname)', '?1'),
                $qb->expr()->like('LOWER(p.surname)', '?2'),
                $qb->expr()->like('LOWER(p.patronymic)', '?3')
            ))  //LOWER(p.firstname) LIKE :firstname
            ->setParameter(1, '%'.addcslashes($fio, '%_').'%')
            ->setParameter(2, '%'.addcslashes($fio, '%_').'%')
            ->setParameter(3, '%'.addcslashes($fio, '%_').'%')
            ->getQuery()->getResult();
    }

    public function findByOrgName($organizationName): array
    {
        $qb = $this->juridicalRepo->createQueryBuilder('p');
        return $qb->select('p')
            ->where($qb->expr()->like('LOWER(p.organizationName)', '?1'))
            ->setParameter(1, '%'.addcslashes($organizationName, '%_').'%')
            ->getQuery()->getResult();
    }

    public function findAllPrivate(string $sort, string $order, int $offset, int $limit): array
    {
        $qb = $this->privateRepo->createQueryBuilder('p');
        return $qb->select('p')
            ->addOrderBy('p'.$sort, $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    public function findAllJuridical(string $sort, string $order, int $offset, int $limit): array
    {
        $qb = $this->juridicalRepo->createQueryBuilder('p');
        return $qb->select('p')
            ->addOrderBy('p'.$sort, $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    public function add(object $subscriber): void
    {
        $this->em->persist($subscriber);
    }


    public function get(Id $id, SubscriberType $subscriberType): object
    {
        if ($subscriberType->isPrivate()) {
            return $this->privateRepo->find($id->getValue());
        } elseif ($subscriberType->isJuridical()) {
            return $this->juridicalRepo->find($id->getValue());
        } else {
            throw new DomainException('Subscriber not found.' . $id->getValue());
        }
    }

    public function remove(object $subscriber): void
    {
        $this->em->remove($subscriber);
    }

}
