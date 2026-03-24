<?php

namespace App\Repository;

use App\Entity\Cailloux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cailloux>
 */
class CaillouxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cailloux::class);
    }

    /**
     * @return Cailloux[]
     */
    public function findByCategorie(string $categorie): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('LOWER(c.categorie) = :categorie')
            ->setParameter('categorie', mb_strtolower($categorie))
            ->orderBy('c.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Cailloux[] Returns an array of Cailloux objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Cailloux
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
