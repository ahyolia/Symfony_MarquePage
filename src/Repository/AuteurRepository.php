<?php

namespace App\Repository;

use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Auteur>
 */
class AuteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auteur::class);
    }

    /**
     * Retourne les auteurs ayant ecrit strictement plus de $nombreMin livres.
     *
     * @return array<int, array{auteur: Auteur, totalLivres: string}>
     */
    public function findAuteursAvecPlusDeNLivres(int $nombreMin): array
    {
        $dql = 'SELECT a AS auteur, COUNT(l.id) AS totalLivres
                FROM App\\Entity\\Auteur a
                JOIN a.livres l
                GROUP BY a.id
                HAVING COUNT(l.id) > :nombreMin
                ORDER BY totalLivres DESC, a.nom ASC';

        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('nombreMin', $nombreMin)
            ->getResult();
    }

    //    /**
    //     * @return Auteur[] Returns an array of Auteur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Auteur
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
