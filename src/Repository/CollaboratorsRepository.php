<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Collaborator;
use App\Entity\Planning;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CollaboratorsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collaborator::class);
    }

    public function save(Collaborator $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Collaborator $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findCollaboratorsOfLoggedInUserPlanning(Planning $planning): array
    {
        return $this->createQueryBuilder(alias: 'collaborator')
            ->where('collaborator.planning = :planning')
            ->setParameter('planning', $planning)
            ->getQuery()
            ->getResult()
        ;
    }
}
