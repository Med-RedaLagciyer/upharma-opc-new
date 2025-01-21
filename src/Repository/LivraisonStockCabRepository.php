<?php

namespace App\Repository;

use App\Entity\LivraisonStockCab;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LivraisonStockCab>
 */
class LivraisonStockCabRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivraisonStockCab::class);
    }

    //    /**
    //     * @return LivraisonStockCab[] Returns an array of LivraisonStockCab objects
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

    //    public function findOneBySomeField($value): ?LivraisonStockCab
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findPositionByTheSameDemande($livraison): array
       {
           return $this->createQueryBuilder('l')
               ->innerJoin('l.demande', 'demande')
               ->innerJoin('l.position', 'position')
               ->andWhere('demande.id = :id_demande')
               ->andWhere('l.id != :id_livraison')
               ->setParameter('id_livraison', $livraison->getId())
               ->setParameter('id_demande', $livraison->getDemande()->getId())
               ->orderBy('l.id', 'ASC')
               ->getQuery()
               ->getResult()
           ;
       }
}
