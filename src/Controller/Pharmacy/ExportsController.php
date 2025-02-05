<?php

namespace App\Controller\Pharmacy;

use DateTime;
use Mpdf\Mpdf;
use App\Entity\UsModule;
use App\Entity\LivraisonStatus;
use App\Controller\ApiController;
use App\Entity\LivraisonStockCab;
use App\Entity\BordereauxValidation;
use App\Entity\LivraisonObservation;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/exports')]
class ExportsController extends AbstractController
{
    private $em;
    private $api;
    public function __construct(ManagerRegistry $doctrine, ApiController $api)
    {
        $this->em = $doctrine->getManager();
        $this->api = $api;
    }

    #[Route('/export_pdf_livraison', name: 'app_pharmacy_exports_export_pdf_livraison', options: ['expose' => true])]
    public function app_pharmacy_livraison_livre_export_pdf_livraison(Request $request)
    {
        ini_set('memory_limit', '-1');

        $livraison_id = $request->get('livraison');
        $livraison = $this->em->getRepository(LivraisonStockCab::class)->find($livraison_id);

        $data_article = [];
        $livraisonPartiel = false;

        foreach ($livraison->getDemande()->getDemandeStockDets() as $demandDet) {
            $article = [];
            $article["code"] = $demandDet->getArticle()->getCode();
            $article["designation"] = $demandDet->getArticle()->getTitre();

            $article["qteLivre"] = 0;
            foreach ($livraison->getLivraisonStockDets() as $livDet) {
                if ($livDet->getArticle()->getId() == $demandDet->getArticle()->getId()) {
                    $article["qteLivre"] = $livDet->getQuantity();
                    break;
                }
            }

            $qteDemande = $demandDet->getQte();
            $article["qteDemande"] = $qteDemande;

            $totalLivraison = 0;
            foreach ($livraison->getDemande()->getLivraisonStockCabs() as $livraison) {
                foreach ($livraison->getLivraisonStockDets() as $livDet) {
                    if ($livDet->getArticle()->getId() == $demandDet->getArticle()->getId()) {
                        $totalLivraison += $livDet->getQuantity();
                    }
                }
            }

            $article["totalLivraison"] = $totalLivraison;
            $article["reste"] = max(0, $qteDemande - $totalLivraison);

            if ($qteDemande != $totalLivraison) {
                $livraisonPartiel = true;
            }

            array_push($data_article, $article);
        }
        // dd($livraisonPartiel);

        $html = $this->render("pharmacy/exports/pdfs/export_pdf_livraison.html.twig", [
            'livraison' => $livraison,
            'livraisonPartiel' => $livraisonPartiel,
            'articles' => $data_article,
        ])->getContent();
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'margin_left' => 5,
            'margin_right' => 5,
        ]);
        $mpdf->showImageErrors = true;
        $mpdf->SetTitle('Livraison');
        $mpdf->SetHTMLHeader(
            $this->render("pharmacy/exports/pdfs/header.html.twig")->getContent()
        );
        $mpdf->SetHTMLFooter(
            $this->render("pharmacy/exports/pdfs/footer.html.twig")->getContent()
        );
        // dd($html);

        $mpdf->WriteHTML($html);
        $mpdf->Output("List Rendez_vous.pdf", "I");
    }
}
