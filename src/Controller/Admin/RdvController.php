<?php

namespace App\Controller\Admin;

use DateTime;
use Mpdf\Mpdf;
use App\Entity\Act;
use App\Entity\User;
use App\Entity\UsModule;
use App\Entity\Rendezvous;
use App\Entity\TAdmission;
use App\Entity\TInscription;
use App\Controller\ApiController;
use App\Entity\PGroupe;
use App\Entity\UsOperation;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/rendez-vous/listing')]
class RdvController extends AbstractController
{
    private $em;
    private $api;
    public function __construct(ManagerRegistry $doctrine, ApiController $api)
    {
        $this->em = $doctrine->getManager();
        $this->api = $api;
    }

    #[Route('/', name: 'app_admin_rdv_listing')]
    public function index(Request $request): Response
    {
        $operations = $this->api->check($this->getUser(), 'app_admin_rdv_listing', $this->em, $request);
        if (!is_array($operations)) {
            return $this->redirectToRoute('app_home');
        } elseif (count($operations) == 0) {
            return $this->render('errors/access_denied.html.twig',);
        }
        $modules = $this->em->getRepository(UsModule::class)->findAll();
        return $this->render('admin/rdv/index.html.twig', [
            'operations' => $operations,
            'modules' => $modules,
        ]);
    }

    #[Route('/list', name: 'app_admin_rdv_listing_list', options: ['expose' => true])]
    public function app_admin_rdv_listing_list(Request $request): Response
    {

        $isAdmin = in_array('ROLE_SUPERADMIN', $this->getUser()->getRoles());
        $groupeFiltre = "";
        if (!$isAdmin) {
            $isInternant = $this->em->getRepository(UsOperation::class)->havePermission(5, $this->getUser());
            $groupe = $this->em->getRepository(PGroupe::class)->findOneBy(['niveau' => 'C']);
            $groupeList = "'" . $groupe->getId() . "'";
            // foreach ($groupe->getGroupes() as $groupe) {
            //     $groupeList .= ",'".$groupe->getId()."'";
            //     foreach ($groupe->getGroupes() as $groupe) {
            //         $groupeList .= ",'".$groupe->getId()."'";
            //     }
            // }
            if ($isInternant) {
                $groupeFiltre = " And grp.id = $groupeList ";
            } else {
                $groupeFiltre = " And grp.id != $groupeList ";
            }
        }
        // dd($isAdmin);
        $draw = $request->query->get('draw');
        $start = $request->query->get('start') ?? 0;
        $length = $request->query->get('length') ?? 10;
        $search = $request->query->all('search')["value"];
        $orderDir = null;
        $orderDir = null;
        if (!empty($request->query->all('order'))) {
            $orderColumnIndex = $request->query->all('order')[0]['column'];
            $orderColumn = $request->query->all("columns")[$orderColumnIndex]['name'];
            $orderDir = $request->query->all('order')[0]['dir'] ?? 'asc';
        }

        $queryBuilder = $this->em->createQueryBuilder()
            ->select('r.id ,r.Code, pat.nom ,pat.prenom ,prm.designation as promotion,grp.niveau, pat.cin, pat.ipp , pat.tel, r.date, r.created, etu.nom as nomEtu, etu.prenom as prenomEtu, adm.code as admCode, r.valider')
            ->from(Rendezvous::class, 'r')
            ->leftJoin('r.Actes', 'a')
            ->innerJoin('r.patient', 'pat')
            ->innerJoin('r.inscription', 'ins')
            ->innerJoin('ins.admission', 'adm')
            ->innerJoin('adm.preinscription', 'pre')
            ->innerJoin('pre.etudiant', 'etu')
            ->innerJoin('ins.promotion', 'prm')
            ->leftJoin('ins.groupe', 'grp')
            ->where("r.Annuler = 0 $groupeFiltre")
            ->groupBy('r.id');
        if (!empty($search)) {
            $queryBuilder->andWhere('(r.Code LIKE :search OR pat.nom LIKE :search OR pat.prenom LIKE :search OR prm.designation LIKE :search OR pat.cin LIKE :search OR r.date LIKE :search OR r.created LIKE :search OR a.designation LIKE :search OR etu.nom LIKE :search OR etu.prenom LIKE :search OR adm.code LIKE :search OR r.statut LIKE :search OR grp.niveau LIKE :search)')
                ->setParameter('search', "%$search%");
        }

        $dateFilter = $request->query->get('filterDate');
        if ($dateFilter != "all") {
            $date = (new \DateTime($dateFilter))->format('Y-m-d');
            // dd($date);
            $queryBuilder->andWhere('r.date LIKE :date')
                ->setParameter('date', $date . '%');
        }

        if (!empty($orderColumn)) {
            $queryBuilder->orderBy("$orderColumn", $orderDir);
        }

        $filteredRecords = count($queryBuilder->getQuery()->getResult());

        // Paginate results
        $queryBuilder->setFirstResult($start)
            ->setMaxResults($length);

        $results = $queryBuilder->getQuery()->getResult();
        // dd($results);
        foreach ($results as $key => $res) {
            $rendezvous = $this->em->getRepository(Rendezvous::class)->find($res["id"]);
            $acts = $rendezvous->getActes();
            $actNames = [];

            foreach ($acts as $act) {
                $designation = $act->getDesignation();
                if (strlen($designation) > 20) {
                    $designation = substr($designation, 0, 20);
                }
                $actNames[] = $designation;
            }

            if (count($actNames) > 1) {
                $results[$key]['acts'] = implode(' - ', $actNames);
            } else {
                $results[$key]['acts'] = reset($actNames);
            }
        }
        // dd($results);
        $totalRecords = $this->em->createQueryBuilder()
            ->select('COUNT(r.id)')
            ->from(Rendezvous::class, 'r')
            ->where('r.Annuler = 0')
            // ->innerJoin('u.client', 'c')
            ->getQuery()
            ->getSingleScalarResult();

        return new JsonResponse([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $results,
        ]);
    }

    #[Route('/details/{rendezvous}', name: 'app_admin_rdv_listing_details', options: ['expose' => true])]
    public function app_admin_rdv_listing_details(Rendezvous $rendezvous): Response
    {
        $detailsRdv = $this->render("admin/rdv/pages/detailsReclamation.html.twig", [
            'rendezvous' => $rendezvous
        ])->getContent();
        return new JsonResponse(['detailsRdv' => $detailsRdv], 200);
    }

    #[Route('/export_excel', name: 'app_admin_rdv_listing_export_excel', options: ['expose' => true])]
    public function app_admin_rdv_listing_export_excel(Request $request)
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        $dateDebut = $request->query->get('dateDebut') ? new \DateTime($request->query->get('dateDebut')) : null;
        $dateFin = $request->query->get('dateFin') ? new \DateTime($request->query->get('dateFin')) : null;

        $isAdmin = in_array('ROLE_SUPERADMIN', $this->getUser()->getRoles());
        // $groupeFiltre = "";
        if (!$isAdmin) {
            $isInternant = $this->em->getRepository(UsOperation::class)->havePermission(5, $this->getUser());
            if ($isInternant) {
                $rendezvous = $this->em->getRepository(Rendezvous::class)->findRendezVousInternatBetweenDates($dateDebut, $dateFin);
                // dd($rendezvous); 
            } else {
                $rendezvous = $this->em->getRepository(Rendezvous::class)->findRendezVousNotInternatBetweenDates($dateDebut, $dateFin);
            }
        } else {
            $rendezvous = $this->em->getRepository(Rendezvous::class)->findRendezVousBetweenDates($dateDebut, $dateFin);
        }
        // dd($rendezvous);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ORD');
        $sheet->setCellValue('B1', 'CODE ADMISSION');
        $sheet->setCellValue('C1', 'NOM ETUDIANT');
        $sheet->setCellValue('D1', 'PRENOM ETUDIANT');
        $sheet->setCellValue('E1', 'PROMOTION');
        $sheet->setCellValue('F1', 'CODE RENDEZ-VOUS');
        $sheet->setCellValue('G1', 'NOM PATIENT');
        $sheet->setCellValue('H1', 'PRENOM PATIENT');
        $sheet->setCellValue('I1', 'CIN PATIENT');
        $sheet->setCellValue('J1', 'IPP PATIENT');
        $sheet->setCellValue('K1', 'TEL PATIENT');
        $sheet->setCellValue('L1', 'ACTES');
        $sheet->setCellValue('M1', 'DATE RENDEZ-VOUS');
        $sheet->setCellValue('N1', 'DATE CREATION');
        $sheet->setCellValue('O1', 'STATUT');
        $i = 2;
        $j = 1;
        foreach ($rendezvous as $rdv) {
            foreach ($rdv->getActes() as $act) {
                $sheet->setCellValue('A' . $i, $i - 1);
                $sheet->setCellValue('B' . $i, $rdv->getInscription()->getAdmission()->getCode());
                $sheet->setCellValue('C' . $i, $rdv->getInscription()->getAdmission()->getPreinscription()->getEtudiant()->getNom());
                $sheet->setCellValue('D' . $i, $rdv->getInscription()->getAdmission()->getPreinscription()->getEtudiant()->getPrenom());
                $sheet->setCellValue('E' . $i, $rdv->getInscription()->getPromotion()->getDesignation());
                $sheet->setCellValue('F' . $i, $rdv->getCode());
                $sheet->setCellValue('G' . $i, $rdv->getPatient()->getNom());
                $sheet->setCellValue('H' . $i, $rdv->getPatient()->getPrenom());
                $sheet->setCellValue('I' . $i, $rdv->getPatient()->getCin());
                $sheet->setCellValue('J' . $i, $rdv->getPatient()->getIpp());
                $sheet->setCellValue('K' . $i, $rdv->getPatient()->getTel());
                $sheet->setCellValue('L' . $i, $act->getDesignation());
                $sheet->setCellValue('M' . $i, $rdv->getDate()->format('Y-m-d h:m:s'));
                $sheet->setCellValue('N' . $i, $rdv->getCreated()->format('Y-m-d h:m:s'));
                $sheet->setCellValue('O' . $i, $rdv->getStatut());
                $i++;
            }
            $j++;
        }

        // die('die');
        $writer = new Xlsx($spreadsheet);
        $fileName = "Extraction Rendez_vous.xlsx";
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    #[Route('/export_pdf', name: 'app_admin_rdv_listing_export_pdf', options: ['expose' => true])]
    public function app_admin_rdv_listing_export_pdf(Request $request)
    {
        ini_set('memory_limit', '-1');

        $dateDebut = $request->query->get('dateDebut') ? new \DateTime($request->query->get('dateDebut')) : null;
        $dateFin = $request->query->get('dateFin') ? new \DateTime($request->query->get('dateFin')) : null;

        $inscriptions = $this->em->getRepository(TInscription::class)->getInscriptionWithRdvByDates($dateDebut, $dateFin);

        $html = $this->render("admin/rdv/pdf/export_pdf.html.twig", [
            'inscriptions' => $inscriptions
        ])->getContent();
        // dd($html);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'margin_left' => 5,
            'margin_right' => 5,
        ]);
        $mpdf->showImageErrors = true;

        $mpdf->SetHTMLHeader(
            $this->render("admin/rdv/pdf/header.html.twig")->getContent()
        );
        // $mpdf->SetHTMLFooter(
        //     $this->render("admin/rdv/pdf/footer.html.twig")->getContent()
        // );
        // dd($html);

        $mpdf->WriteHTML($html);
        $mpdf->SetTitle('List Rendez-vous');
        $mpdf->Output("List Rendez_vous.pdf", "I");
    }
}
