<?php

namespace App\Repository;

use App\Entity\Sejour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sejour>
 */
class SejourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sejour::class);
    }

    /**
     * @return Sejour[]
     */
    public function findCurrentAndFuture(): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.dateFin >= :date')
            ->orderBy('s.dateDebut', 'ASC')
            ->setParameter('date', date('Y-m-d'))
            ->getQuery()
            ->getResult();
    }
}
