<?php

namespace App\Repository;

use App\Entity\Livres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livres>
 */
class LivresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livres::class);
    }

    /**
     * Retourne les livres dont le titre commence par la lettre fournie.
     *
     * @return Livres[]
     */
    public function findByTitreInitiale(string $lettre): array
    {
        $lettre = mb_substr(trim($lettre), 0, 1);

        if ($lettre === '') {
            return [];
        }

        $dql = 'SELECT l FROM App\\Entity\\Livres l WHERE UPPER(l.titre) LIKE UPPER(:prefixe) ORDER BY l.titre ASC';

        return $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('prefixe', $lettre . '%')
            ->getResult();
    }

    /**
     * Retourne le nombre total de livres en base.
     */
    public function countAllLivres(): int
    {
        $dql = 'SELECT COUNT(l.id) FROM App\\Entity\\Livres l';

        return (int) $this->getEntityManager()
            ->createQuery($dql)
            ->getSingleScalarResult();
    }

//    /**
//     * @return Livres[] Returns an array of Livres objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Livres
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
