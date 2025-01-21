<?php

namespace App\Controller\Admin\Parametrage;

use App\Entity\User;
use App\Entity\Users;
use App\Entity\UDepot;
use App\Entity\UAntenne;
use App\Entity\UArticle;
use App\Entity\UFamille;
use App\Entity\Interfacage;
use App\Entity\CommandeType;
use App\Entity\TInscription;
use App\Entity\UPPartenaire;
use App\Entity\DemandeStatus;
use App\Entity\DemandeTypeOp;
use App\Entity\DemandeStockCab;
use App\Entity\DemandeStockDet;
use App\Controller\ApiController;
use App\Entity\LivraisonStockCab;
use App\Entity\LivraisonStockDet;
use App\Entity\InterfacageMissing;
use App\Entity\LivraisonStockLot;
use App\Entity\PNaturePrix;
use App\Service\AccessDatabaseService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('admin/parametrage/synchronisation')]
class SyncController extends AbstractController
{
    private $em;
    private $accessDatabaseService;

    public function __construct(AccessDatabaseService $accessDatabaseService, ManagerRegistry $doctrine)
    {
        $this->accessDatabaseService = $accessDatabaseService;
        $this->em = $doctrine->getManager();
        ini_set('max_execution_time', 6000);
        ini_set('memory_limit', '-1');
    }

    #[Route('/', name: 'app_admin_synchronisation', options: ['expose' => true])]
    public function synchronisation(Request $request): Response
    {
        return $this->render('admin/parametrage/sync/index.html.twig', []);
    }

    private function saveInterfacageMissing($tableName, $identifiant, $value){
        $interfacageMissing = new InterfacageMissing();
        $interfacageMissing->setTableName($tableName);
        $interfacageMissing->setIdentifiant($identifiant);
        $interfacageMissing->setValue($value);
        $interfacageMissing->setTraite(0);
        $this->em->persist($interfacageMissing);
        $this->em->flush();
        return("done");
    }

    #[Route('/api_article', name: 'api_article', options: ['expose' => true])]
    public function api_article()
    {
        $insertedCount = 0;

        $lastArticle = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pArticles"]);
        $lastArticleId = $lastArticle ? $lastArticle->getLastId() : 1;

        $sql = "SELECT  TOP 5000 * FROM pArticles WHERE Auto >" . $lastArticleId . " ORDER BY Auto";
        $results = $this->accessDatabaseService->query($sql);
        try {
            if($results){
                foreach ($results as $result) {
                    $articleExist = $this->em->getRepository(UArticle::class)->find($result["ID_Article"]);
                    if($articleExist){
                        continue;
                    }
                    $article = new UArticle();
                    $article->setId($result["ID_Article"]);
                    $article->setCode($result["ID_Article"]);
                    $article->setTitre($result["Article"]);
                    $article->setStockMin($result["Stock_Min"]);
                    $article->setStockMax($result["Stock_Max"]);
                    $article->setCodeBarre($result["CodeBarre"]);
                    $article->setActive(!$result["Desactiver"]);
                    $article->setIdAccess($result["Auto"]);

                    $famille = $this->em->getRepository(UFamille::class)->findOneBy(["code" => $result['ID_Famille']]);
                    if($famille){
                        $article->setFamille($famille);
                    }

                    $this->em->persist($article);
                    $insertedCount++;
                }

                $this->em->flush();
            }

            $lastArticle = $lastArticle ? $lastArticle : new Interfacage();
            $articles = $this->em->getRepository(UArticle::class)->findBy([], ['id' => 'DESC']);
            $lastArticle->setTabelName("pArticles");
            $lastArticle->setLastId($articles[0]->getIdAccess());

            $this->em->persist($lastArticle);
            $this->em->flush();

            return new JsonResponse(['message' => 'Articles inserted successfully.', 'countInserted' => $insertedCount, 'countTotal' => count($articles)], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    #[Route('/api_demande_cab', name: 'api_demande_cab', options: ['expose' => true])]
    public function api_demande_cab()
    {
        $insertedCount = 0;

        $lastDemandeCab = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pVCommande"]);
        $lastDemandeCabId = $lastDemandeCab ? $lastDemandeCab->getLastId() : 1;

        $sql = "SELECT  TOP 5000 * FROM pVCommande WHERE Auto >" . $lastDemandeCabId . " AND ID_Client = 'M17025' ORDER BY Auto";
        $results = $this->accessDatabaseService->query($sql);
        // dd($sql);
        try {
            if($results){
                foreach ($results as $result) {
                    $demandeCabExist = $this->em->getRepository(DemandeStockCab::class)->findOneBy(["code" => $result["ID_Commande"]]);
                    if($demandeCabExist){
                        continue;
                    }

                    $antenneRecepteur = $antenneDemandeur = $dossier = $patient = NULL;
                    if($result["ID_MagHosixDst"] !== NULL){
                        $antenneDemandeur = $this->em->getRepository(UAntenne::class)->findOneBy(["magHosi" => $result["ID_MagHosixDst"]]);
                    }
                    if($result["ID_MagHosixSrc"] !== NULL){
                        $antenneRecepteur = $this->em->getRepository(UAntenne::class)->findOneBy(["magHosi" => $result["ID_MagHosixSrc"]]);
                    }
                    if ($result['ID_SceHosix']) {
                        $depot = $this->em->getRepository(UDepot::class)->findOneBy(['sceHosi' => $result['ID_SceHosix']]);
                        $dossier = $depot ? $depot->getDossier() : null;
                    }

                    $commandeType = $this->em->getRepository(CommandeType::class)->findOneBy(["code" => $result['ID_Motif']]);

                    $client = $this->em->getRepository(UPPartenaire::class)->findOneBy(['code' => $result['ID_Client']]);

                    $status = $this->em->getRepository(DemandeStatus::class)->find(1);

                    if($result['Patient'] !== ""){
                        $patient = mb_convert_encoding($result['Patient'], 'UTF-8', 'Windows-1252');
                    }
                    if($result['Obs'] !== ""){
                        $observation = mb_convert_encoding($result['Obs'], 'UTF-8', 'Windows-1252');
                    }

                    $typeOp = $result['Nature'] === 'Vente' ? $this->em->getRepository(DemandeTypeOp::class)->find(1) : null;

                    $demandeCab = new DemandeStockCab();
                    $demandeCab->setCode($result["ID_Commande"]);
                    $demandeCab->setIpp($result['IPP']);
                    $demandeCab->setDi($result['DI']);
                    $demandeCab->setPatient($patient);
                    $demandeCab->setObservation($observation);
                    $demandeCab->setDossierPatient($result['Dossier']);
                    $demandeCab->setTipoFacturac($result['IDTipoFacturac']);
                    $demandeCab->setDate(new \DateTime($result['Date_Commande']));

                    $demandeCab->setClient($client);
                    $demandeCab->setAntenneDemandeur($antenneDemandeur);
                    $demandeCab->setAntenne($antenneRecepteur);
                    $demandeCab->setDemandeur($dossier);
                    $demandeCab->setTypeOp($typeOp);
                    $demandeCab->setCommandeType($commandeType);
                    $demandeCab->setStatus($status);
                    $demandeCab->setActive(true);


                    $demandeCab->setIdAccess($result["Auto"]);

                    $this->em->persist($demandeCab);
                    $insertedCount++;
                }

                $this->em->flush();
            }

            $lastDemandeCab = $lastDemandeCab ? $lastDemandeCab : new Interfacage();
            $demandeCabs = $this->em->getRepository(DemandeStockCab::class)->findBy([], ['idAccess' => 'DESC']);
            $lastDemandeCab->setTabelName("pVCommande");
            $lastDemandeCab->setLastId($demandeCabs[0]->getIdAccess());

            $this->em->persist($lastDemandeCab);
            $this->em->flush();

            return new JsonResponse(['message' => 'DemandeCabs inserted successfully.', 'countInserted' => $insertedCount, 'countTotal' => count($demandeCabs)], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    #[Route('/api_demande_det', name: 'api_demande_det', options: ['expose' => true])]
    public function api_demande_det()
    {
        $insertedCount = 0;

        $lastDemandeDet = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pVCommande_LG"]);
        $lastDemandeDetId = $lastDemandeDet ? $lastDemandeDet->getLastId() : 1;

        $sql = "SELECT TOP 5000 lg.Auto, lg.ID_Article, lg.ID_Commande,lg.Quantite_CD, lg.Quantite_SV
FROM pVCommande_LG lg
INNER JOIN pVCommande ON lg.ID_Commande = pVCommande.ID_Commande
WHERE lg.Auto > ".$lastDemandeDetId."
  AND pVCommande.ID_Client = 'M17025' ORDER BY lg.Auto;";
        $results = $this->accessDatabaseService->query($sql);
        // dd($sql);
        try {
            if($results){
                foreach ($results as $result) {
                    // dd($result);
                    $demandeCab = $this->em->getRepository(DemandeStockCab::class)->findOneBy(["code" => $result["ID_Commande"]]);
                    if(!$demandeCab){
                        // dd($result["ID_Commande"]);
                        // Save the missing demandeCab to sync it later
                        $this->saveInterfacageMissing("pVCommande", "ID_Commande", $result["ID_Commande"]);
                        // save the current table as well
                        $this->saveInterfacageMissing("pVCommande_LG", "Auto", $result["Auto"]);
                        continue;
                    }

                    $article = $this->em->getRepository(UArticle::class)->find($result["ID_Article"]);
                    if(!$article){
                        // Save the missing article to sync it later
                        $this->saveInterfacageMissing("pArticles", "ID_Article", $result["ID_Article"]);
                        // save the current table as well
                        $this->saveInterfacageMissing("pVCommande_LG", "Auto", $result["Auto"]);
                        continue;
                    }

                    $demandeDet = new DemandeStockDet();
                    $demandeDet->setIdAccess($result["Auto"]);
                    $demandeDet->setArticle($article);
                    $demandeDet->setQte($result['Quantite_CD'] ?? 0);
                    $demandeDet->setQtLivre($result['Quantite_SV'] ?? 0);
                    $demandeDet->setDemandeCab($demandeCab);




                    $this->em->persist($demandeDet);
                    $insertedCount++;
                }

                $this->em->flush();
            }

            $lastDemandeDet = $lastDemandeDet ? $lastDemandeDet : new Interfacage();
            $demandeDets = $this->em->getRepository(DemandeStockDet::class)->findBy([], ['idAccess' => 'DESC']);
            $lastDemandeDet->setTabelName("pVCommande_LG");
            $lastDemandeDet->setLastId($demandeDets[0]->getIdAccess());

            $this->em->persist($lastDemandeDet);
            $this->em->flush();

            return new JsonResponse(['message' => 'Articles inserted successfully.', 'countInserted' => $insertedCount, 'countTotal' => count($demandeDets)], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    #[Route('/api_livraison_cab', name: 'api_livraison_cab', options: ['expose' => true])]
    public function api_livraison_cab()
    {
        $insertedCount = 0;

        $lastLivraisonCab = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pVLivraison"]);
        $lastLivraisonCabId = $lastLivraisonCab ? $lastLivraisonCab->getLastId() : 1;

        $sql = "SELECT  TOP 5000 pVLivraison.Auto, pVLivraison.ID_Commande,pVLivraison.ID_Livraison,pVLivraison.Date_Livraison,pVLivraison.ID_DegrerUrg, pVLivraison.ID_Reference FROM pVLivraison
        INNER JOIN pVCommande ON pVLivraison.ID_Commande = pVCommande.ID_Commande
        WHERE pVLivraison.Auto >" . $lastLivraisonCabId . " AND pVCommande.ID_Client = 'M17025' ORDER BY pVLivraison.Auto;";
        $results = $this->accessDatabaseService->query($sql);
        // dd($results);
        try {
            if($results){
                foreach ($results as $result) {
                    $livraisonCabExist = $this->em->getRepository(LivraisonStockCab::class)->findOneBy(["code" => $result["ID_Livraison"]]);
                    if($livraisonCabExist){
                        continue;
                    }

                    $demandeCab = $this->em->getRepository(DemandeStockCab::class)->findOneBy(["code" => $result["ID_Commande"]]);
                    if(!$demandeCab){
                        // Save the missing demandeCab to sync it later
                        $this->saveInterfacageMissing("pVCommande", "ID_Commande", $result["ID_Commande"]);
                        // save the current table as well
                        $this->saveInterfacageMissing("pVLivraison", "Auto", $result["Auto"]);
                        continue;
                    }

                    $livraisonCab = new LivraisonStockCab();
                    $livraisonCab->setIdAccess($result["Auto"]);
                    $livraisonCab->setCode($result["ID_Livraison"]);
                    $livraisonCab->setDate(new \DateTime($result["Date_Livraison"]));
                    $livraisonCab->setUrgent($result['ID_DegrerUrg'] === 'URG' ? 1 : 0);
                    $livraisonCab->setStatus($this->em->getRepository(DemandeStatus::class)->find(1));
                    $livraisonCab->setActive(true);
                    $livraisonCab->setDemande($demandeCab);

                    if($result['ID_Reference']!=0){
                        $idReference = $this->em->getRepository(LivraisonStockCab::class)->findOneBy(["code" => $result['ID_Reference']]);
                        $livraisonCab->setIdReference($idReference);
                    }


                    $this->em->persist($livraisonCab);
                    $insertedCount++;
                }

                $this->em->flush();
            }

            $lastLivraisonCab = $lastLivraisonCab ? $lastLivraisonCab : new Interfacage();
            $livraisonCabs = $this->em->getRepository(LivraisonStockCab::class)->findBy([], ['idAccess' => 'DESC']);
            $lastLivraisonCab->setTabelName("pVLivraison");
            $lastLivraisonCab->setLastId($livraisonCabs[0]->getIdAccess());

            $this->em->persist($lastLivraisonCab);
            $this->em->flush();

            return new JsonResponse(['message' => 'LivraisonCab inserted successfully.', 'countInserted' => $insertedCount, 'countTotal' => count($livraisonCabs)], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    #[Route('/api_livraison_det', name: 'api_livraison_det', options: ['expose' => true])]
    public function api_livraison_det()
    {
        $insertedCount = 0;

        $lastLivraisonDet = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pVLivraison_LG"]);
        $lastLivraisonDetId = $lastLivraisonDet ? $lastLivraisonDet->getLastId() : 1;

        $sql = "SELECT  TOP 5000 lg.Auto, lg.ID_Livraison, lg.ID_Article, lg.Quantite_BL
        FROM (pVLivraison_LG lg
        INNER JOIN pVLivraison ON pVLivraison.ID_Livraison = lg.ID_Livraison)
        INNER JOIN pVCommande ON pVLivraison.ID_Commande = pVCommande.ID_Commande
        WHERE lg.Auto >" . $lastLivraisonDetId . " AND pVCommande.ID_Client = 'M17025' ORDER BY lg.Auto";
        $results = $this->accessDatabaseService->query($sql);
        // dd($results);
        try {
            if($results){
                foreach ($results as $result) {

                    $livraisonCab = $this->em->getRepository(LivraisonStockCab::class)->findOneBy(["code" => $result["ID_Livraison"]]);
                    if(!$livraisonCab){
                        // Save the missing demandeCab to sync it later
                        $this->saveInterfacageMissing("pVLivraison", "ID_Livraison", $result["ID_Livraison"]);
                        // save the current table as well
                        $this->saveInterfacageMissing("pVLivraison_LG", "Auto", $result["Auto"]);
                        continue;
                    }

                    $article =$this->em->getRepository(UArticle::class)->find($result["ID_Article"]);
                    if(!$article){
                        // Save the missing article to sync it later
                        $this->saveInterfacageMissing("pArticles", "ID_Article", $result["ID_Article"]);
                        // save the current table as well
                        $this->saveInterfacageMissing("pVLivraison_LG", "Auto", $result["Auto"]);
                        continue;
                    }

                    $livraisonDet = new LivraisonStockDet();
                    $livraisonDet->setIdAccess($result["Auto"]);
                    $livraisonDet->setLivraison($livraisonCab);
                    $livraisonDet->setArticle($article);
                    $livraisonDet->setQuantity($result['Quantite_BL']);


                    $this->em->persist($livraisonDet);
                    $insertedCount++;
                }

                $this->em->flush();
            }

            $lastLivraisonDet = $lastLivraisonDet ? $lastLivraisonDet : new Interfacage();
            $livraisonDets = $this->em->getRepository(LivraisonStockDet::class)->findBy([], ['idAccess' => 'DESC']);
            $lastLivraisonDet->setTabelName("pVLivraison_LG");
            $lastLivraisonDet->setLastId($livraisonDets[0]->getIdAccess());

            $this->em->persist($lastLivraisonDet);
            $this->em->flush();

            return new JsonResponse(['message' => 'LivraisonDet inserted successfully.', 'countInserted' => $insertedCount, 'countTotal' => count($livraisonDets)], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    #[Route('/api_livraison_lot', name: 'api_livraison_lot', options: ['expose' => true])]
    public function api_livraison_lot()
    {
        $insertedCount = 0;

        $lastLivraisonLot = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pVLivraison_LT"]);
        $lastLivraisonLotId = $lastLivraisonLot ? $lastLivraisonLot->getLastId() : 1;

        $sql = "SELECT  TOP 5000 lot.Auto, lot.ID_Livraison, lot.Lot, lot.Date_Sys, lot.Date_Expir, lot.Quantite_LT, lot.Quantite_RT, lot.ID_Nature_Prix, lot.Prix_Vente, lot.Prix_Achat, lot.Montant, lot.Taux, lot.ValeurA, lot.Marge
        FROM (pVLivraison_LT lot
        INNER JOIN pVLivraison ON pVLivraison.ID_Livraison = lot.ID_Livraison)
        INNER JOIN pVCommande ON pVLivraison.ID_Commande = pVCommande.ID_Commande
        WHERE lot.Auto >" . $lastLivraisonLotId . " AND pVCommande.ID_Client = 'M17025' ORDER BY lot.Auto";

        $results = $this->accessDatabaseService->query($sql);
        // dd($results);
        try {
            if($results){
                foreach ($results as $result) {

                    $livraisonCab = $this->em->getRepository(LivraisonStockCab::class)->findOneBy(["code" => $result["ID_Livraison"]]);
                    if(!$livraisonCab){
                        // Save the missing demandeCab to sync it later
                        $this->saveInterfacageMissing("pVLivraison", "ID_Livraison", $result["ID_Livraison"]);
                        // save the current table as well
                        $this->saveInterfacageMissing("pVLivraison_LT", "Auto", $result["Auto"]);
                        continue;
                    }

                    $livraisonLot = new LivraisonStockLot();
                    $livraisonLot->setIdAccess($result["Auto"]);
                    $livraisonLot->setLivraisonCab($livraisonCab);
                    $livraisonLot->setDateSys(new \DateTime($result["Date_Sys"]));
                    $livraisonLot->setLot($result["Lot"]);
                    $livraisonLot->setDatePeremption(new \DateTime($result["Date_Expir"]));
                    $livraisonLot->setQuantite($result['Quantite_LT']);
                    $livraisonLot->setQuantiteRetour($result['Quantite_RT']);

                    $naturePrix = $this->em->getRepository(PNaturePrix::class)->find($result['ID_Nature_Prix']);
                    $livraisonLot->setNaturePrix($naturePrix);

                    $livraisonLot->setPrixVenteTtc($result['Prix_Vente']);
                    $livraisonLot->setPrixAchatHt($result['Prix_Achat']);
                    $livraisonLot->setMontant($result['Montant']);
                    $livraisonLot->setTva($result['Taux']);
                    $livraisonLot->setValeurA($result['ValeurA']);
                    $livraisonLot->setMerge($result['Marge']);


                    $this->em->persist($livraisonLot);
                    $insertedCount++;
                }

                $this->em->flush();
            }

            $lastLivraisonCab = $lastLivraisonLot ? $lastLivraisonLot : new Interfacage();
            $livraisonLots = $this->em->getRepository(LivraisonStockLot::class)->findBy([], ['idAccess' => 'DESC']);
            $lastLivraisonCab->setTabelName("pVLivraison_LT");
            $lastLivraisonCab->setLastId($livraisonLots[0]->getIdAccess());

            $this->em->persist($lastLivraisonCab);
            $this->em->flush();

            return new JsonResponse(['message' => 'LivraisonLot inserted successfully.', 'countInserted' => $insertedCount, 'countTotal' => count($livraisonLots)], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    #[Route('/fixArticleMissing', name: 'fixArticleMissing', options: ['expose' => true])]
    public function fixArticleMissing(){
        $lastArticle = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pArticles"]);
        $lastArticleId = $lastArticle ? $lastArticle->getLastId() : 1;

        $idList = NULL ;
        $sql = "
            SELECT TOP 5000 *
            FROM pArticles
            WHERE ID_Article IN ($idList)
            ORDER BY Auto
        ";
        $results = $this->accessDatabaseService->query($sql);
        // try {
            if($results){
                foreach ($results as $result) {
                    $articleExist = $this->em->getRepository(UArticle::class)->find($result["ID_Article"]);
                    // dd($result);
                    $article = new UArticle();
                    $article->setId($result["ID_Article"]);
                    $article->setCode($result["ID_Article"]);
                    $article->setTitre($result["Article"]);
                    $article->setStockMin($result["Stock_Min"]);
                    $article->setStockMax($result["Stock_Max"]);
                    $article->setCodeBarre($result["CodeBarre"]);
                    $article->setActive(!$result["Desactiver"]);
                    $article->setIdAccess($result["Auto"]);

                    $famille = $this->em->getRepository(UFamille::class)->findOneBy(["code" => $result['ID_Famille']]);
                    if($famille){
                        $article->setFamille($famille);
                    }

                    $this->em->persist($article);
                }

                $this->em->flush();
            }

            $lastArticle = $lastArticle ? $lastArticle : new Interfacage();
            $articles = $this->em->getRepository(UArticle::class)->findBy([], ['id' => 'DESC']);
            $lastArticle->setTabelName("pArticles");
            $lastArticle->setLastId($articles[0]->getIdAccess());

            $this->em->persist($lastArticle);
            $this->em->flush();

            return new JsonResponse(['message' => 'Articles inserted successfully.','countTotal' => count($articles)], 200);

        // } catch (\Throwable $th) {
        //     return new JsonResponse('Erreur de connection..!!', 500);
        // }
    }
}
