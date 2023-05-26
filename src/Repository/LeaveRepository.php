<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Leave;
use App\Entity\Planning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LeaveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Leave::class);
    }

    public function save(Leave $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Leave $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLeavesOfLoggedInUserPlanning(Planning $planning): array
    {
        return $this->createQueryBuilder(alias: 'leave')
            ->where('leave.planning = :planning')
            ->setParameter('planning', $planning)
            ->getQuery()
            ->getResult()
        ;
    }
}
