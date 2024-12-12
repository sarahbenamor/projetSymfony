<?php

namespace App\Repository;

use App\Entity\Trajet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }
    public function findByLigne(?int $ligne): array
    {
        if (!$ligne) {
            return [];

        }

        return $this->createQueryBuilder('t')
            ->where('t.ligne LIKE :ligne')
            ->setParameter('ligne', '%' . $ligne . '%')
            ->getQuery()
            ->getResult();
    }
    public function findTrajetPlusDemande()
    {
        return $this->createQueryBuilder('t')
            ->select('t.pointDepart, t.destination, COUNT(t.id) AS nombre_reservations')
            ->groupBy('t.pointDepart, t.destination')
            ->orderBy('nombre_reservations', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
}
