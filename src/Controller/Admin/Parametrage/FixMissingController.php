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
use App\Entity\LivraisonStatus;
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

#[Route('admin/parametrage/synchronisation_fix')]
class FixMissingController extends AbstractController
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

    // #[Route('/', name: 'app_admin_synchronisation', options: ['expose' => true])]
    // public function synchronisation(Request $request): Response
    // {
    //     return $this->render('admin/parametrage/sync/index.html.twig', []);
    // }

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

    #[Route('/api_article_fix', name: 'api_article_fix', options: ['expose' => true])]
    public function api_article_fix()
    {
        $insertedCount = 0;

        $lastArticle = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pArticles"]);
        $lastArticleId = $lastArticle ? $lastArticle->getLastId() : 0;

        $sql = "SELECT * FROM pArticles WHERE Auto >" . $lastArticleId . " ORDER BY Auto";
        $results = $this->accessDatabaseService->query($sql);
        // dd($results);
        try {
            if($results){
                foreach ($results as $result) {
                    $articleExist = $this->em->getRepository(UArticle::class)->find($result["ID_Article"]);
                    if($articleExist){
                        // dd($articleExist, $results);
                        continue;
                    }
                    $article = new UArticle();
                    $article->setId($result["ID_Article"]);
                    $article->setCode($result["ID_Article"]);

                    $titre =  mb_convert_encoding($result['Article'], 'UTF-8', 'Windows-1252');
                    $article->setTitre($titre);
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
            $articles = $this->em->getRepository(UArticle::class)->findBy([], ['idAccess' => 'DESC']);
            $lastArticle->setTabelName("pArticles");
            $lastArticle->setLastId($articles[0]->getIdAccess());

            $this->em->persist($lastArticle);
            $this->em->flush();
            // dd("hi");
            return new JsonResponse(['message' => 'Articles inserted successfully.', 'countInserted' => $insertedCount, 'countTotal' => count($articles)], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    #[Route('/api_demande_cab_fix', name: 'api_demande_cab_fix', options: ['expose' => true])]
    public function api_demande_cab_fix()
    {
        $insertedCount = 0;

        $missings = $this->em->getRepository(InterfacageMissing::class)->findBy(["tableName" => "pVCommande", "traite" => 0]);
        // dd($missings);
        // try {
            if($missings){
                foreach ($missings as $missing) {
                    $sql = "SELECT * FROM pVCommande WHERE ". $missing->getIdentifiant()." = " . $missing->getValue() . ";";
                    $result = $this->accessDatabaseService->query($sql)[0];
                    // dd($result);
                    $demandeCabExist = $this->em->getRepository(DemandeStockCab::class)->findOneBy(["code" => $result["ID_Commande"]]);
                    if($demandeCabExist){
                        $missing->setTraite(1);
                        $this->em->flush();
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
                    $missing->setTraite(1);
                    $this->em->flush();
                }

                $this->em->flush();
            }

            // dd("done");
            return new JsonResponse(['message' => 'DemandeCabs inserted successfully.'], 200);

        // } catch (\Throwable $th) {
        //     return new JsonResponse('Erreur de connection..!!', 500);
        // }
    }

    #[Route('/api_demande_det_fix', name: 'api_demande_det_fix', options: ['expose' => true])]
    public function api_demande_det_fix()
    {
        $insertedCount = 0;

        $missings = $this->em->getRepository(InterfacageMissing::class)->findBy(["tableName" => "pVCommande_LG", "traite" => 0]);

        // dd($sql);
        // try {
            if($missings){
                foreach ($missings as $missing) {
                    $sql = "SELECT * FROM pVCommande_LG WHERE ". $missing->getIdentifiant()." = " . $missing->getValue() . ";";
                    $result = $this->accessDatabaseService->query($sql)[0];
                    $Exist = $this->em->getRepository(DemandeStockDet::class)->findOneBy(["idAccess" => $result["Auto"]]);
                    if($Exist){
                        $missing->setTraite(1);
                        $this->em->flush();
                        continue;
                    }
                    // dd($result);
                    $demandeCab = $this->em->getRepository(DemandeStockCab::class)->findOneBy(["code" => $result["ID_Commande"]]);
                    if(!$demandeCab){
                        // dd($result["ID_Commande"]);
                        // Save the missing demandeCab to sync it later
                        // $this->saveInterfacageMissing("pVCommande", "ID_Commande", $result["ID_Commande"]);
                        // // save the current table as well
                        // $this->saveInterfacageMissing("pVCommande_LG", "Auto", $result["Auto"]);
                        continue;
                    }

                    $article = $this->em->getRepository(UArticle::class)->find($result["ID_Article"]);
                    if(!$article){
                        // Save the missing article to sync it later
                        // $this->saveInterfacageMissing("pArticles", "ID_Article", $result["ID_Article"]);
                        // // save the current table as well
                        // $this->saveInterfacageMissing("pVCommande_LG", "Auto", $result["Auto"]);
                        continue;
                    }

                    $demandeDet = new DemandeStockDet();
                    $demandeDet->setIdAccess($result["Auto"]);
                    $demandeDet->setArticle($article);
                    $demandeDet->setQte($result['Quantite_CD'] ?? 0);
                    $demandeDet->setQtLivre($result['Quantite_SV'] ?? 0);
                    $demandeDet->setDemandeCab($demandeCab);
                    $demandeDet->setLignCd($result['Ligne_CD']);




                    $this->em->persist($demandeDet);
                    $insertedCount++;
                    $missing->setTraite(1);
                    $this->em->flush();
                }

                $this->em->flush();
            }

            return new JsonResponse(['message' => 'Articles inserted successfully.'], 200);

        // } catch (\Throwable $th) {
        //     return new JsonResponse('Erreur de connection..!!', 500);
        // }
    }

    #[Route('/api_livraison_cab_fix', name: 'api_livraison_cab_fix', options: ['expose' => true])]
    public function api_livraison_cab_fix()
    {
        $insertedCount = 0;

        $missings = $this->em->getRepository(InterfacageMissing::class)->findBy(["tableName" => "pVLivraison", "traite" => 0]);
        // dd($missings);
        try {
            if($missings){
                foreach ($missings as $missing) {
                    $sql = "SELECT * FROM pVLivraison WHERE ". $missing->getIdentifiant()." = " . $missing->getValue() . ";";
                    $result = $this->accessDatabaseService->query($sql)[0];
                    // dd($result);
                    $Exist = $this->em->getRepository(LivraisonStockCab::class)->findOneBy(["idAccess" => $result["Auto"]]);
                    if($Exist){
                        // dd($Exist);
                        $missing->setTraite(1);
                        $this->em->flush();
                        continue;
                    }

                    $demandeCab = $this->em->getRepository(DemandeStockCab::class)->findOneBy(["code" => $result["ID_Commande"]]);
                    if(!$demandeCab){
                        dd("hi",  $result["ID_Commande"]);
                        // // Save the missing demandeCab to sync it later
                        // $this->saveInterfacageMissing("pVCommande", "ID_Commande", $result["ID_Commande"]);
                        // // save the current table as well
                        // $this->saveInterfacageMissing("pVLivraison", "Auto", $result["Auto"]);
                        continue;
                    }

                    $livraisonCab = new LivraisonStockCab();
                    $livraisonCab->setIdAccess($result["Auto"]);
                    $livraisonCab->setCode($result["ID_Livraison"]);
                    $livraisonCab->setDate(new \DateTime($result["Date_Livraison"]));
                    $livraisonCab->setUrgent($result['ID_DegrerUrg'] === 'URG' ? 1 : 0);
                    $livraisonCab->setStatus($this->em->getRepository(LivraisonStatus::class)->find(1));
                    $livraisonCab->setActive(true);
                    $livraisonCab->setDemande($demandeCab);

                    if($result['ID_Reference']!=0){
                        $idReference = $this->em->getRepository(LivraisonStockCab::class)->findOneBy(["code" => $result['ID_Reference']]);
                        $livraisonCab->setIdReference($idReference);
                    }


                    $this->em->persist($livraisonCab);
                    $insertedCount++;
                    $missing->setTraite(1);
                    $this->em->flush();
                }

                $this->em->flush();
            }


            return new JsonResponse(['message' => 'LivraisonCab inserted successfully.'], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    #[Route('/api_livraison_det_fix', name: 'api_livraison_det_fix', options: ['expose' => true])]
    public function api_livraison_det_fix()
    {
        // dd("hi");
        $insertedCount = 0;

        $missings = $this->em->getRepository(InterfacageMissing::class)->findBy(["tableName" => "pVLivraison_LG", "traite" => 0]);

        // dd($results);
        // try {
            if($missings){
                foreach ($missings as $missing) {

                    $sql = "SELECT * FROM pVLivraison_LG WHERE ". $missing->getIdentifiant()." = " . $missing->getValue() . ";";
                    $result = $this->accessDatabaseService->query($sql);
                    // dd($result,$missing->getValue(),$missing->getIdentifiant());
                    if(!$result){
                        continue;
                    }
                    // dd($result);
                    $Exist = $this->em->getRepository(LivraisonStockDet::class)->findOneBy(["idAccess" => $result[0]["Auto"]]);
                    if($Exist){
                        $missing->setTraite(1);
                        $this->em->flush();
                        continue;
                    }

                    $livraisonCab = $this->em->getRepository(LivraisonStockCab::class)->findOneBy(["code" => $result[0]["ID_Livraison"]]);


                    // dd($demandeDet, $result['Ligne_CD'], $livraisonCab->getDemande());
                    if(!$livraisonCab){
                        // Save the missing demandeCab to sync it later
                        // $this->saveInterfacageMissing("pVLivraison", "ID_Livraison", $result["ID_Livraison"]);
                        // // save the current table as well
                        // $this->saveInterfacageMissing("pVLivraison_LG", "Auto", $result["Auto"]);
                        continue;
                    }

                    $demandeDet = $this->em->getRepository(DemandeStockDet::class)->findOneBy(["demandeCab" => $livraisonCab->getDemande(), "lignCd" => $result[0]['Ligne_CD']]);
                    $article =$this->em->getRepository(UArticle::class)->find($result[0]["ID_Article"]);
                    if(!$article){
                        // Save the missing article to sync it later
                        // $this->saveInterfacageMissing("pArticles", "ID_Article", $result["ID_Article"]);
                        // // save the current table as well
                        // $this->saveInterfacageMissing("pVLivraison_LG", "Auto", $result["Auto"]);
                        continue;
                    }

                    $livraisonDet = new LivraisonStockDet();
                    $livraisonDet->setIdAccess($result[0]["Auto"]);
                    $livraisonDet->setLivraison($livraisonCab);
                    $livraisonDet->setArticle($article);
                    $livraisonDet->setQuantity($result[0]['Quantite_BL']);
                    $livraisonDet->setLignCd($result[0]['Ligne_CD']);
                    $livraisonDet->setLignBl($result[0]['Ligne_BL']);
                    $livraisonDet->setDemandeDet($demandeDet);

                    $this->em->persist($livraisonDet);
                    $insertedCount++;
                    $missing->setTraite(1);
                    $this->em->flush();
                }

                $this->em->flush();
            }


            return new JsonResponse(['message' => 'LivraisonDet inserted successfully.'], 200);

        // } catch (\Throwable $th) {
        //     return new JsonResponse('Erreur de connection..!!', 500);
        // }
    }

    #[Route('/api_livraison_lot_fix', name: 'api_livraison_lot_fix', options: ['expose' => true])]
    public function api_livraison_lot_fix()
    {
        $insertedCount = 0;

        $missings = $this->em->getRepository(InterfacageMissing::class)->findBy(["tableName" => "pVLivraison_LT", "traite" => 0]);
        // dd($results);
        // dd($results);
        try {
            if($missings){
                foreach ($missings as $missing) {

                    $sql = "SELECT * FROM pVLivraison_LT WHERE ". $missing->getIdentifiant()." = " . $missing->getValue() . ";";
                    $result = $this->accessDatabaseService->query($sql);
                    if(!$result){
                        continue;
                    }
                    $Exist = $this->em->getRepository(LivraisonStockLot::class)->findOneBy(["idAccess" => $result[0]["Auto"]]);
                    if($Exist){
                        $missing->setTraite(1);
                        $this->em->flush();
                        continue;
                    }
                    // dd($result);

                    $livraisonCab = $this->em->getRepository(LivraisonStockCab::class)->findOneBy(["code" => $result[0]["ID_Livraison"]]);


                    // dd($livraisonDet);

                    if(!$livraisonCab){
                        // Save the missing demandeCab to sync it later
                        // $this->saveInterfacageMissing("pVLivraison", "ID_Livraison", $result["ID_Livraison"]);
                        // // save the current table as well
                        // $this->saveInterfacageMissing("pVLivraison_LT", "Auto", $result["Auto"]);
                        continue;
                    }
                    $livraisonDet = $this->em->getRepository(LivraisonStockDet::class)->findOneBy(["livraison" => $livraisonCab, "lignBl" => $result[0]['Ligne_BL']]);

                    // $livraisonDet = $this->em->getRepository(LivraisonStockDet::class)->findOneBy(["code" => $result["ID_Livraison"]]);


                    $livraisonLot = new LivraisonStockLot();
                    $livraisonLot->setIdAccess($result[0]["Auto"]);
                    $livraisonLot->setLivraisonCab($livraisonCab);
                    $livraisonLot->setDateSys(new \DateTime($result[0]["Date_Sys"]));
                    $livraisonLot->setLot($result[0]["Lot"]);
                    $livraisonLot->setDatePeremption(new \DateTime($result[0]["Date_Expir"]));
                    $livraisonLot->setQuantite($result[0]['Quantite_LT']);
                    $livraisonLot->setQuantiteRetour($result[0]['Quantite_RT']);

                    $naturePrix = $this->em->getRepository(PNaturePrix::class)->find($result[0]['ID_Nature_Prix']);
                    $livraisonLot->setNaturePrix($naturePrix);

                    $livraisonLot->setPrixVenteTtc($result[0]['Prix_Vente']);
                    $livraisonLot->setPrixAchatHt($result[0]['Prix_Achat']);
                    $livraisonLot->setMontant($result[0]['Montant']);
                    $livraisonLot->setTva($result[0]['Taux']);
                    $livraisonLot->setValeurA($result[0]['ValeurA']);
                    $livraisonLot->setMerge($result[0]['Marge']);
                    $livraisonLot->setLignBl($result[0]['Ligne_BL']);
                    $livraisonLot->setLivraisonDet($livraisonDet);


                    $this->em->persist($livraisonLot);
                    $insertedCount++;
                    $missing->setTraite(1);
                    $this->em->flush();
                }

                $this->em->flush();
            }


            return new JsonResponse(['message' => 'LivraisonLot inserted successfully.'], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    // #[Route('/fixArticleMissing', name: 'fixArticleMissing', options: ['expose' => true])]
    // public function fixArticleMissing(){
    //     $lastArticle = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pArticles"]);
    //     $lastArticleId = $lastArticle ? $lastArticle->getLastId() : 0;

    //     $idList = NULL ;
    //     $sql = "
    //         SELECT TOP 5000 *
    //         FROM pArticles
    //         WHERE ID_Article IN ($idList)
    //         ORDER BY Auto
    //     ";
    //     $results = $this->accessDatabaseService->query($sql);
    //     // try {
    //         if($results){
    //             foreach ($results as $result) {
    //                 $articleExist = $this->em->getRepository(UArticle::class)->find($result["ID_Article"]);
    //                 // dd($result);
    //                 $article = new UArticle();
    //                 $article->setId($result["ID_Article"]);
    //                 $article->setCode($result["ID_Article"]);
    //                 $article->setTitre($result["Article"]);
    //                 $article->setStockMin($result["Stock_Min"]);
    //                 $article->setStockMax($result["Stock_Max"]);
    //                 $article->setCodeBarre($result["CodeBarre"]);
    //                 $article->setActive(!$result["Desactiver"]);
    //                 $article->setIdAccess($result["Auto"]);

    //                 $famille = $this->em->getRepository(UFamille::class)->findOneBy(["code" => $result['ID_Famille']]);
    //                 if($famille){
    //                     $article->setFamille($famille);
    //                 }

    //                 $this->em->persist($article);
    //             }

    //             $this->em->flush();
    //         }

    //         $lastArticle = $lastArticle ? $lastArticle : new Interfacage();
    //         $articles = $this->em->getRepository(UArticle::class)->findBy([], ['id' => 'DESC']);
    //         $lastArticle->setTabelName("pArticles");
    //         $lastArticle->setLastId($articles[0]->getIdAccess());

    //         $this->em->persist($lastArticle);
    //         $this->em->flush();

    //         return new JsonResponse(['message' => 'Articles inserted successfully.','countTotal' => count($articles)], 200);

    //     // } catch (\Throwable $th) {
    //     //     return new JsonResponse('Erreur de connection..!!', 500);
    //     // }
    // }
}
