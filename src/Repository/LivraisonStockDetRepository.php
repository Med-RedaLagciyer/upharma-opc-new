<?php

namespace App\Repository;

use App\Entity\LivraisonStockDet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LivraisonStockDet>
 */
class LivraisonStockDetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LivraisonStockDet::class);
    }

    //    /**
    //     * @return LivraisonStockDet[] Returns an array of LivraisonStockDet objects
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

    //    public function findOneBySomeField($value): ?LivraisonStockDet
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findRelatedDemandeDet($livraison, $lignCd): array
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.livraison', 'livraisonCab')
            ->innerJoin('livraisonCab.demande', 'demandeCab')
            ->innerJoin('demandeCab.demandeStockDets', 'dets')
            ->where('demandeCab.active = 1')
            ->andWhere('livraisonCab.active = 1')
            ->andWhere('livraisonCab.id = :id_liv')
            ->andWhere('l.lignCd = :lignCd')
            ->setParameter('lignCd', $lignCd)
            ->setParameter('id_liv', $livraison->getId())
            ->getQuery()
            ->getResult()
        ;
    }


    public function findExtractionPharmacyData(): array
    {
        return $this->createQueryBuilder('livdet')
        ->select(
            'demandeCab.code AS dmcode',
            'demandeCab.date AS dmdate',
            'livcab.code AS livcode',
            'livcab.date AS livdate',
            'demandeCab.dossierPatient',
            'demandeCab.patient',
            'partenaire.nom AS client_name',
            'article.id AS article_id',
            'article.titre AS article_titre',
            'livdet.quantity',
            'livlot.prixVenteTtc AS prix_vente_ttc',
            'livlot.prixAchatHt AS prix_achat_ht',
            'livlot.montant AS montant',
            'status.designation AS statut_livraison',
            'position.position AS position_livraison',
            'livcab.etat AS etat_livraison'
        )
        ->innerJoin('livdet.livraison', 'livcab')
        ->innerJoin('livcab.demande', 'demandeCab')
        ->innerJoin('demandeCab.client', 'partenaire')
        ->innerJoin('livdet.article', 'article')
        ->innerJoin('livcab.status', 'status')
        ->leftJoin('livcab.position', 'position')
        ->leftJoin('livdet.livraisonStockLots', 'livlot') // Correction ici
        ->where('partenaire.id = :clientId')
        ->andWhere('livcab.active = 1')
        ->setParameter('clientId', 2694)
        ->getQuery()
        ->getResult();
    }
}
