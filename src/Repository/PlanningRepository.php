<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Collaborator;
use App\Entity\Planning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PlanningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planning::class);
    }

    public function save(Planning $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Planning $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findDetailssOfLoggedInUserPlanning(Collaborator $collaborator): array
    {
        return $this->createQueryBuilder(alias: 'planning')
            ->innerJoin('planning.collaborators', 'collaborator')
            ->where('collaborator = :collaborator')
            ->setParameter('collaborator', $collaborator)
            ->getQuery()
            ->getResult()
        ;
    }
}
