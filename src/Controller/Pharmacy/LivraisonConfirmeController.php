<?php

namespace App\Controller\Pharmacy;

use DateTime;
use App\Entity\UsModule;
use App\Entity\ListPosition;
use App\Entity\LivraisonStatus;
use App\Controller\ApiController;
use App\Entity\LivraisonStockCab;
use App\Entity\LivraisonObservation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/pharmacy/livraison/confirme')]
class LivraisonConfirmeController extends AbstractController
{
    private $em;
    private $api;
    public function __construct(ManagerRegistry $doctrine, ApiController $api)
    {
        $this->em = $doctrine->getManager();
        $this->api = $api;
    }
    #[Route('/', name: 'app_pharmacy_livraison_confirme')]
    public function index(Request $request): Response
    {
        $operations = $this->api->check($this->getUser(), 'app_pharmacy_livraison_confirme', $this->em, $request);

        if (!is_array($operations)) {
            return $this->redirectToRoute('app_home');
        } elseif (count($operations) == 0) {
            return $this->render('errors/access_denied.html.twig');
        }
        $modules = $this->em->getRepository(UsModule::class)->findAll();
        return $this->render('pharmacy/livraison_confirme/index.html.twig', [
            'operations' => $operations,
            'modules' => $modules,
        ]);
    }

    #[Route('/list', name: 'app_pharmacy_livraison_confirme_list', options: ['expose' => true])]
    public function app_pharmacy_livraison_confirme_list(Request $request): Response
    {
        $operations = $this->api->check($this->getUser(), 'app_pharmacy_livraison_confirme', $this->em, $request);
        $filteredActions = array_filter($operations, function($operation) {
            return ($operation->isAlign());
        });
        $allActions = array_map(function($action) {
            return [
                'idOp'=> $action->getId(),
                'idName' => $action->getIdTag(),
                'nom' => $action->getDesignation(),
                'className' => $action->getClassTag(),
                'icon' => $action->getIcon(),
            ];
        }, $filteredActions);

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
            ->select('livCab.id ,livCab.code as code_liv_cab, livCab.date as date_liv, demandeCab.code as code_dem_cab, demandeCab.date as date_dem, demandeCab.patient, demandeCab.dossierPatient, status.designation as statut_liv')
            ->from(LivraisonStockCab::class, 'livCab')
            ->innerJoin('livCab.demande', 'demandeCab')
            ->innerJoin('demandeCab.client', 'client')
            ->innerJoin('livCab.status', 'status')
            ->where('demandeCab.active = 1')
            ->andWhere('livCab.active = 1')
            ->andWhere('status.id = 3')
            ->andWhere('client.id = 2694');
        if (!empty($search)) {
            $queryBuilder->andWhere('(livCab.code LIKE :search OR demandeCab.code LIKE :search OR livCab.date LIKE :search OR demandeCab.date LIKE :search OR demandeCab.patient LIKE :search OR demandeCab.dossierPatient LIKE :search OR status.designation LIKE :search)')
                ->setParameter('search', "%$search%");
        }

        if (!empty($orderColumn)) {
            $queryBuilder->orderBy("$orderColumn", $orderDir);
        }

        $filteredRecords = count($queryBuilder->getQuery()->getResult());

        // Paginate results
        $queryBuilder->setFirstResult($start)
            ->setMaxResults($length);

        $results = $queryBuilder->getQuery()->getResult();

        $totalRecords = $this->em->createQueryBuilder()
            ->select('COUNT(livCab.id)')
            ->from(LivraisonStockCab::class, 'livCab')
            ->innerJoin('livCab.demande', 'demandeCab')
            ->innerJoin('demandeCab.client', 'client')
            ->innerJoin('livCab.status', 'status')
            ->where('demandeCab.active = 1')
            ->andWhere('livCab.active = 1')
            ->andWhere('status.id = 3')
            ->andWhere('client.id = 2694')
            ->getQuery()
            ->getSingleScalarResult();
        return new JsonResponse([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $results,
            'actions' => $allActions
        ]);
    }

    #[Route('/details', name: 'app_pharmacy_livraison_confirme_details', options: ['expose' => true])]
    public function app_pharmacy_livraison_confirme_details(Request $request): Response
    {
        $idLivraison = $request->get('idLivraison');
        $codeLivraison = $request->get('codeLivraison');

        $livraison =!$idLivraison ? $this->em->getRepository(LivraisonStockCab::class)->findOneBy(['code' => $codeLivraison]) : $this->em->getRepository(LivraisonStockCab::class)->find($idLivraison);

        if (!$livraison) {
            return new JsonResponse(['error' => 'Aucune Livraison trouvée.'], 404);
        }

        $operations = $this->api->check($this->getUser(), 'app_pharmacy_livraison_confirme', $this->em, $request);
        $detailLivraison = $this->render("pharmacy/livraison_confirme/pages/detailsLivraison.html.twig", [
            'livraison' => $livraison,
            'operations' => $operations,
        ])->getContent();
        return new JsonResponse(['detailLivraison' => $detailLivraison], 200);
    }

    #[Route('/prete', name: 'app_pharmacy_livraison_confirme_preter', options: ['expose' => true])]
    public function app_pharmacy_livraison_confirme_preter(Request $request): Response
    {
        $idLivraison = $request->get('id_livraison');

        $livraison = $this->em->getRepository(LivraisonStockCab::class)->find($idLivraison);

        if (!$livraison) {
            return new JsonResponse(['error' => 'Aucun Livraison.'], 404);
        }

        $livraisonParDemande = $this->em->getRepository(LivraisonStockCab::class)->findPositionByTheSameDemande($livraison);

        $LivraisonPosition = NULL;
        if($livraisonParDemande){
            $LivraisonPosition =$livraisonParDemande[0]->getPosition() ;
        }else{
            $position = $this->em->getRepository(ListPosition::class)->findOneBy(["isReserved" => false]);
            if(!$position){
                return new JsonResponse(['error' => 'Tous les postitions sont occupées.'], 404);
            }
            $LivraisonPosition = $position;
        }

        $status = $this->em->getRepository(LivraisonStatus::class)->find(4);
        $livraison->setStatus($status);
        $livraison->setPosition($LivraisonPosition);

        $LivraisonPosition->setReserved(True);

        $this->em->flush();

        return new JsonResponse("Livraison est prête pour envoi, sur position : ".$LivraisonPosition->getPosition(), 200);
    }
    #[Route('/future', name: 'app_pharmacy_livraison_confirme_future', options: ['expose' => true])]
    public function app_pharmacy_livraison_confirme_future(Request $request): Response
    {
        // dd($request);
        $idLivraison = $request->get('livraison');
        $dateFuture = $request->get('date');

        $livraison = $this->em->getRepository(LivraisonStockCab::class)->find($idLivraison);

        if (!$livraison) {
            return new JsonResponse(['error' => 'Aucun Livraison.'], 404);
        }

        $livraisonParDemande = $this->em->getRepository(LivraisonStockCab::class)->findPositionByTheSameDemande($livraison);

        $LivraisonPosition = NULL;
        if($livraisonParDemande){
            $LivraisonPosition =$livraisonParDemande[0]->getPosition() ;
        }else{
            $position = $this->em->getRepository(ListPosition::class)->findOneBy(["isReserved" => false]);
            if(!$position){
                return new JsonResponse(['error' => 'Tous les postitions sont occupées.'], 404);
            }
            $LivraisonPosition = $position;
        }

        $status = $this->em->getRepository(LivraisonStatus::class)->find(5);
        $livraison->setStatus($status);
        $livraison->setPosition($LivraisonPosition);
        $livraison->setDateFuture(new DateTime($dateFuture));

        $LivraisonPosition->setReserved(True);

        $this->em->flush();

        return new JsonResponse("Livraison est prévue en". $dateFuture .", sur position : ".$LivraisonPosition->getPosition(), 200);
    }

    #[Route('/observation', name: 'app_pharmacy_livraison_confirme_observation', options: ['expose' => true])]
    public function app_pharmacy_livraison_confirme_observation(Request $request): Response
    {
        $livraisons = $request->get('livraisons');
        $observation = $request->get('observation');

        if(!$livraisons || $livraisons == []){
            return new JsonResponse(['error' => 'Merci de choisir une ou plusieurs livraisons.'], 500);
        }

        if(!$observation || $observation === ""){
            return new JsonResponse(['error' => 'Merci d\'inserer l\'observation.'], 500);
        }

        foreach($livraisons as $idLivraison){
            $livraison = $this->em->getRepository(LivraisonStockCab::class)->find($idLivraison);

            if (!$livraison) {
                return new JsonResponse(['error' => 'Aucune Livraison trouvée.'], 404);
            }

            $livraisonObs = new LivraisonObservation();
            $livraisonObs->setLivraison($livraison);
            $livraisonObs->setObservation($observation);
            $livraisonObs->setUserCreated($this->getUser());
            $livraisonObs->setCreated(new DateTime('now'));
            $livraisonObs->setStatus($livraison->getStatus()->getDesignation());
            $this->em->persist($livraisonObs);
        }

        $this->em->flush();

        // dd($idLivraison,$observation);
        return new JsonResponse("Observation enregistré avec succès.", 200);
    }
}
