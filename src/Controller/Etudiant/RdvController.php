<?php

namespace App\Controller\Etudiant;

use DateTime;
use App\Entity\Act;
use App\Entity\User;
use App\Entity\Patient;
use App\Entity\Rendezvous;
use App\Entity\TAdmission;
use App\Entity\Parametrage;
use App\Entity\TInscription;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/etudiant/rendez-vous/listing')]
class RdvController extends AbstractController
{
    private $em;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }
    #[Route('/', name: 'app_etudiant_rdv_listing')]
    public function index(): Response
    {
        $admission = $this->em->getRepository(TAdmission::class)->findOneBy(['code' => $this->getUser()->getUsername()]);
        $inscription = $this->em->getRepository(TInscription::class)->findOneBy(['admission' => $admission, "statut" => 13], ["id" => "desc"]);
        $actes = $this->em->getRepository(Act::class)->findBy(["promotion" => $inscription->getPromotion()]);
        $patients = $this->em->getRepository(Patient::class)->findBy(["active" => 1]);
        return $this->render('etudiant/rdv/index.html.twig', [
            'actes' => $actes,
            'patients' => $patients,
        ]);
    }
    #[Route('/list', name: 'app_etudiant_rdv_listing_list', options: ['expose' => true])]
    public function app_admin_rdv_listing_list(Request $request): Response
    {
        $admission = $this->em->getRepository(TAdmission::class)->findOneBy(['code' => $this->getUser()->getUsername()]);
        $inscription = $this->em->getRepository(TInscription::class)->findOneBy(['admission' => $admission, "statut" => 13], ["id" => "desc"]);

        $draw = $request->query->get('draw');
        $start = $request->query->get('start') ?? 0;
        $length = $request->query->get('length') ?? 10;
        $search = $request->query->all('search')["value"];
        $orderDir = null;
        if (!empty($request->query->all('order'))) {
            $orderColumnIndex = $request->query->all('order')[0]['column'];
            $orderColumn = $request->query->all("columns")[$orderColumnIndex]['name'];
            $orderDir = $request->query->all('order')[0]['dir'] ?? 'asc';
        }

        $queryBuilder = $this->em->createQueryBuilder()
            ->select('r.id ,r.Code, pat.nom ,pat.prenom , pat.cin, pat.ipp , pat.tel, r.date, r.created, r.valider')
            ->from(Rendezvous::class, 'r')
            ->leftJoin('r.Actes', 'a')
            ->innerJoin('r.patient', 'pat')
            ->where('r.inscription = :inscription')
            ->andWhere('r.Annuler = 0')
            ->setParameter('inscription', $inscription)
            ->groupBy('r.id');
        if (!empty($search)) {
            $queryBuilder->andWhere('(r.Code LIKE :search OR pat.nom LIKE :search OR pat.prenom LIKE :search OR prm.designation LIKE :search OR pat.cin LIKE :search OR r.date LIKE :search OR r.created LIKE :search OR a.designation LIKE :search OR etu.nom LIKE :search OR etu.prenom LIKE :search OR adm.code LIKE :search OR r.statut LIKE :search OR pat.ipp LIKE :search OR pat.tel LIKE :search)')
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

        foreach ($results as $key => $res) {
            $rendezvous = $this->em->getRepository(Rendezvous::class)->find($res["id"]);
            $acts = $rendezvous->getActes();
            // dd($rendezvous->getActes()->toArray());
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
            // dd($actNames);
        }
        // dd($results);
        $totalRecords = $this->em->createQueryBuilder()
            ->select('COUNT(r.id)')
            ->from(Rendezvous::class, 'r')
            ->where('r.inscription = :inscription')
            ->andWhere('r.Annuler = 0')
            ->setParameter('inscription', $inscription)
            // ->innerJoin('u.client', 'c')
            ->getQuery()
            ->getSingleScalarResult();
        // dd($results);
        return new JsonResponse([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $results,
        ]);
    }


    #[Route('/detailpatient/{patient}', name: 'app_etudiant_rdv_getPatientInfo', options: ['expose' => true])]
    public function app_etudiant_rdv_getPatientInfo(Patient $patient): Response
    {
        return new JsonResponse([
            'nom' => $patient->getNom(),
            'prenom' => $patient->getPrenom(),
            'cin' => $patient->getCin(),
            'tel' => $patient->getTel(),
            'ipp' => $patient->getIpp(),
        ], 200);
    }

    #[Route('/new', name: 'app_etudiant_rdv_listing_new', options: ['expose' => true])]
    public function app_etudiant_rdv_listing_new(Request $request): Response
    {
        $admission = $this->em->getRepository(TAdmission::class)->findOneBy(['code' => $this->getUser()->getUsername()]);
        $inscription = $this->em->getRepository(TInscription::class)->findOneBy(['admission' => $admission, "statut" => 13], ["id" => "desc"]);

        if ($request->get('isPatient') == "no") {
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $cin = $request->request->get('cin');
            $tel = $request->request->get('tel');
            $ipp = $request->request->get('ipp');

            if (!$nom || !$prenom || !$tel || !$cin) {
                return new JsonResponse("Merci de remplir tous les champs.", 500);
            }

            $cinExiste = $this->em->getRepository(Patient::class)->findOneBy(['cin' => $cin]);
            if ($cinExiste) {
                return new JsonResponse("Patient existe déjà.", 500);
            }

            $patient = new Patient();
            $patient->setNom($nom);
            $patient->setPrenom($prenom);
            $patient->setCin($cin);
            $patient->setIpp($ipp);
            $patient->setTel($tel);
            $patient->setCreated(new DateTime('now'));
            $patient->setUserCreated($this->getUser());
        } else {
            $patient = $this->em->getRepository(Patient::class)->find($request->get('patientSelect'));
            $ipp = $request->request->get('ipp');

            if (!$ipp && !$patient->getIpp()) {
                return new JsonResponse("Merci de remplir tous les champs.", 500);
            }

            $patient->setIpp($ipp);
        }

        if (!$patient) {
            return new JsonResponse("Patient introuvable!", 500);
        }

        $date = \DateTime::createFromFormat('Y-m-d\TH:i', $request->request->get('date'));
        $actes_ids = json_decode($request->request->get('actes'));
        $actes = $this->em->getRepository(Act::class)->findBy(['id' => $actes_ids]);

        if (!$date || !$actes) {
            return new JsonResponse("Merci de remplir tous les champs.", 500);
        }

        $today = new DateTime();

        if ($date <= $today) {
            return new JsonResponse("La date sélectionnée doit être au minimum celle de demain.", 500);
        }

        $rdvSameDate = $this->em->getRepository(Rendezvous::class)->findRdvByDate($date, $inscription);
        $rdvSamePatient = $this->em->getRepository(Rendezvous::class)->findRdvByPatient($date, $inscription, $patient->getId());
        $parametrage = $this->em->getRepository(Parametrage::class)->find(1);

        if (count($rdvSameDate) >= $parametrage->getNPatient()) {
            return new JsonResponse("Vous avez le droit de créer un seul rendez-vous par jour.", 500);
        }

        if ($rdvSamePatient) {
            return new JsonResponse("Vous avez le droit de créer un seul rendez-vous par patient dans un jour.", 500);
        }

        if ($request->get('isPatient') == "no") {
            $this->em->persist($patient);
        }

        $rendezvous = new Rendezvous();
        $rendezvous->setInscription($inscription);
        $rendezvous->setCreated(new DateTime('now'));
        $rendezvous->setDate($date);
        $rendezvous->setPatient($patient);

        foreach ($actes as $acte) {
            $rendezvous->addActe($acte);
        }

        $this->em->persist($rendezvous);
        $this->em->flush();

        $rendezvous->setCode('RDV-FDA_' . str_pad($rendezvous->getId(), 8, '0', STR_PAD_LEFT));
        $this->em->flush();

        return new JsonResponse("Rendez-vous ajouté avec succès.", 200);
    }

    #[Route('/details/{rendezvous}', name: 'app_etudiant_rdv_listing_details', options: ['expose' => true])]
    public function app_etudiant_rdv_listing_details(Rendezvous $rendezvous): Response
    {
        $detailsRdv = $this->render("etudiant/rdv/pages/detailsReclamation.html.twig", [
            'rendezvous' => $rendezvous
        ])->getContent();
        return new JsonResponse(['detailsRdv' => $detailsRdv], 200);
    }

    #[Route('/annuler', name: 'app_etudiant_rdv_listing_annuler', options: ['expose' => true])]
    public function app_etudiant_rdv_listing_annuler(Request $request): Response
    {
        $rendezvous = $this->em->getRepository(Rendezvous::class)->find($request->request->get('rendezvous'));
        if ($rendezvous->isValider()) {
            return new JsonResponse("Ce rendez-vous est déja validé.", 500);
        }
        $rendezvous->setAnnuler(1);
        $rendezvous->setAnnulated(new DateTime('now'));
        $this->em->flush();
        return new JsonResponse("Rendez-vous annulé avec succès.", 200);
    }

    #[Route('/valider', name: 'app_etudiant_rdv_listing_valider', options: ['expose' => true])]
    public function app_etudiant_rdv_listing_valider(Request $request): Response
    {
        $rendezvous = $this->em->getRepository(Rendezvous::class)->find($request->request->get('rendezvous'));
        $rendezvous->setValider(1);
        $rendezvous->setValidated(new DateTime('now'));
        $rendezvous->setStatut('Validé');
        $this->em->flush();
        return new JsonResponse("Rendez-vous validé avec succès.", 200);
    }
}
