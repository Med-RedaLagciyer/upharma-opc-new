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
use App\Entity\LivraisonStockDet;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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

    #[Route('/export_excel_livraison', name: 'app_pharmacy_exports_export_excel_livraison', options: ['expose' => true])]
    public function app_pharmacy_exports_export_excel_livraison(Request $request)
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $livraisons = $this->em->getRepository(LivraisonStockDet::class)->findExtractionPharmacyData();
        // dd($livraisons);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('LIVRAISONS');
        $sheet->setCellValue('A1', 'ORD');
        $sheet->setCellValue('B1', 'CODE COMMANDE');
        $sheet->setCellValue('C1', 'DATE COMMANDE');
        $sheet->setCellValue('D1', 'CODE LIVRAISON');
        $sheet->setCellValue('E1', 'DATE LIVRAISON');
        $sheet->setCellValue('F1', 'DOSSIER PATIENT');
        $sheet->setCellValue('G1', 'CLIENT');
        $sheet->setCellValue('H1', 'NOM');
        $sheet->setCellValue('I1', 'ID_ARTICLE');
        $sheet->setCellValue('J1', 'TITRE');
        $sheet->setCellValue('K1', 'QUANTITY');
        $sheet->setCellValue('L1', 'PRIX VENTE TTC');
        $sheet->setCellValue('M1', 'PRIX ACHAT HT');
        $sheet->setCellValue('N1', 'MONTANT');
        $sheet->setCellValue('O1', 'STATUT LIVRAISON');
        $sheet->setCellValue('P1', 'POSITION LIVRAISON');
        $sheet->setCellValue('Q1', 'ETAT LIVRAISON');
        $i = 2;
        foreach ($livraisons as $livraison) {
                // dd($detail,$detail->getLivraisonStockLots()[0]);
            $sheet->setCellValue('A' . $i, $i - 1);
            $sheet->setCellValue('B' . $i, $livraison["dmcode"]);
            $sheet->setCellValue('C' . $i, $livraison["dmdate"]->format('Y-m-d'));
            $sheet->setCellValue('D' . $i, $livraison["livcode"]);
            $sheet->setCellValue('E' . $i, $livraison["livdate"]->format('Y-m-d'));
            $sheet->setCellValue('F' . $i, $livraison["dossierPatient"]);
            $sheet->setCellValue('G' . $i, $livraison["patient"]);
            $sheet->setCellValue('H' . $i, $livraison["client_name"]);
            $sheet->setCellValue('I' . $i, $livraison["article_id"]);
            $sheet->setCellValue('J' . $i, $livraison["article_titre"]);
            $sheet->setCellValue('K' . $i, $livraison["quantity"]);
            $sheet->setCellValue('L' . $i, $livraison["prix_vente_ttc"]);
            $sheet->setCellValue('M' . $i, $livraison["prix_achat_ht"]);
            $sheet->setCellValue('N' . $i, $livraison["montant"]);
            $sheet->setCellValue('O' . $i, $livraison["statut_livraison"]);
            $sheet->setCellValue('P' . $i, $livraison["position_livraison"]);
            $sheet->setCellValue('Q' . $i, $livraison["etat_livraison"]);
            $i++;
        }

        // die('die');
        $writer = new Xlsx($spreadsheet);
        $fileName = "ETAT LIVRAISON ". (new DateTime())->format('d-m-Y') .".xlsx";
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
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
        $mpdf->Output("LIVRAISON-".$livraison->getCode(), "I");
    }

    #[Route('/export_pdf_brd', name: 'app_pharmacy_exports_export_pdf_brd', options: ['expose' => true])]
    public function app_pharmacy_exports_export_pdf_brd(Request $request)
    {
        ini_set('memory_limit', '-1');

        $brd_id = $request->get('brd_id');
        $bordereaux = $this->em->getRepository(BordereauxValidation::class)->find($brd_id);

        $html = $this->render("pharmacy/exports/pdfs/export_pdf_brd.html.twig", [
            'bordereaux' => $bordereaux,
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
        $mpdf->Output("BORDEREAUX-".$bordereaux->getCode(), "I");
    }
}
