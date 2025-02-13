<?php

namespace App\Controller\Pharmacy;

use App\Entity\UArticle;
use App\Entity\UsModule;
use App\Entity\DemandeStockDet;
use App\Entity\LivraisonStatus;
use App\Controller\ApiController;
use App\Entity\LivraisonStockCab;
use App\Entity\LivraisonStockDet;
use App\Entity\BordereauxValidation;
use App\Entity\LivraisonObservation;
use App\Service\AccessDatabaseService;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/misc')]
class MiscController extends AbstractController
{
    private $em;
    private $api;
    private $accessDatabaseService;
    public function __construct(AccessDatabaseService $accessDatabaseService, ManagerRegistry $doctrine, ApiController $api)
    {
        $this->em = $doctrine->getManager();
        $this->api = $api;
        $this->accessDatabaseService = $accessDatabaseService;
    }
    #[Route('/maj', name: 'app_pharmacy_misc_maj', options: ['expose' => true])]
    public function app_pharmacy_misc_maj(Request $request): Response
    {
        $livraison_id = $request->get('livraison_id');
        $livraison = $this->em->getRepository(LivraisonStockCab::class)->find($livraison_id);
        $demandeDets = $livraison->getDemande()->getDemandeStockDets();
        $livraisonDets = $livraison->getLivraisonStockDets();
        $livraisonLots = $livraison->getLivraisonStockLot();
        // dd($livraisonLots[0]);
        foreach($demandeDets as $demDet){
            $sql = "SELECT Auto, ID_Article, Quantite_CD, Quantite_SV FROM pVCommande_LG WHERE Auto =" . $demDet->getIdAccess() . " ORDER BY Auto";
            $result = $this->accessDatabaseService->query($sql);
            // dd($result);

            $article = $this->em->getRepository(UArticle::class)->find($result[0]["ID_Article"]);

            $demDet->setArticle($article);
            $demDet->setQte($result[0]["Quantite_CD"]);
            $demDet->setQtLivre($result[0]["Quantite_SV"]);
        }

        foreach($livraisonDets as $livDet){
            $sql = "SELECT Auto, ID_Article, Quantite, Ligne_BL, Ligne_CD FROM pVLivraison_LG WHERE Auto =" . $livDet->getIdAccess() . " ORDER BY Auto";
            $result = $this->accessDatabaseService->query($sql);

            $article = $this->em->getRepository(UArticle::class)->find($result[0]["ID_Article"]);
            $demandeDet = $this->em->getRepository(DemandeStockDet::class)->findOneBy(["demandeCab" => $livraison->getDemande(), "lignCd" => $result[0]['Ligne_CD']]);

            $livDet->setArticle($article);
            $livDet->setQuantity($result[0]["Quantite"]);
            $livDet->setLignBl($result[0]["Ligne_BL"]);
            $livDet->setLignCd($result[0]["Ligne_CD"]);
            $livDet->setDemandeDet($demandeDet);
        }

        foreach($livraisonLots as $livlot){
            $sql = "SELECT Auto, Quantite_LT, Quantite_RT, Ligne_BL FROM pVLivraison_LT WHERE Auto =" . $livlot->getIdAccess() . " ORDER BY Auto";
            $result = $this->accessDatabaseService->query($sql);
            // dd($result);
            $livraisonDet = $this->em->getRepository(LivraisonStockDet::class)->findOneBy(["livraison" => $livraison, "lignBl" => $result[0]['Ligne_BL']]);

            $livlot->setQuantite($result[0]['Quantite_LT']);
            $livlot->setQuantiteRetour($result[0]['Quantite_RT']);
            $livlot->setLignBl($result[0]['Ligne_BL']);
            $livlot->setLivraisonDet($livraisonDet);
        }

        $this->em->flush();

        return new JsonResponse("MAJ avec succès.", 200);
    }
}
