<?php

namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicule::class);
    }
//     public function findVehiculePlusUtilise()
// {
//     return $this->createQueryBuilder('v')
//         ->select('v', 'COUNT(t.id) AS nombre_trajets')
//         ->join('v.trajets', 't')
//         ->groupBy('v.id')
//         ->orderBy('nombre_trajets', 'DESC')
//         ->setMaxResults(1)
//         ->getQuery()
//         ->getSingleResult();
// }
public function findVehiculePlusUtilise()
{
    $result = $this->createQueryBuilder('v')
        ->select('v', 'COUNT(t.id) AS nombre_trajets')
        ->join('v.trajets', 't')
        ->groupBy('v.id')
        ->orderBy('nombre_trajets', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult(); // Use getOneOrNullResult() to handle no result gracefully

    if ($result) {
        // 'result' is now an associative array, so we can directly access nombre_trajets
        $vehicule = $result[0]; // The first element is the Vehicule entity
        $nombre_trajets = $result['nombre_trajets']; // Access the count directly
        $vehicule->nombre_trajets = $nombre_trajets; // Assign the count to the Vehicule entity (if you want to pass it to the template)

        return $vehicule; // Return the vehicle with the count
    }

    return null; // If no result is found, return null
}

public function updateStatutVehiculeIndisponible()
{
    $this->createQueryBuilder('v')
        ->update()
        ->set('v.statut', ':statut')
        ->where('v.capacite = (
            SELECT COUNT(t.id) 
            FROM App\Entity\Trajet t 
            WHERE t.vehicule = v
        )')
        ->setParameter('statut', 'indisponible')
        ->getQuery()
        ->execute();
}



}
