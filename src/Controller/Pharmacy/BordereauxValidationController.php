<?php

namespace App\Controller\Pharmacy;

use DateTime;
use App\Entity\UsModule;
use App\Entity\LivraisonStatus;
use App\Controller\ApiController;
use App\Entity\BordereauxValidation;
use App\Entity\LivraisonStockCab;
use App\Service\UserActivityLogger;
use App\Entity\LivraisonObservation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/pharmacy/livraison/bordereaux')]
class BordereauxValidationController extends AbstractController
{
    private $em;
    private $api;
    private $activityLogger;
    public function __construct(ManagerRegistry $doctrine, ApiController $api,UserActivityLogger $activityLogger)
    {
        $this->em = $doctrine->getManager();
        $this->api = $api;
        $this->activityLogger = $activityLogger;
    }

    #[Route('/', name: 'app_pharmacy_brd')]
    public function index(Request $request): Response
    {
        $operations = $this->api->check($this->getUser(), 'app_pharmacy_brd', $this->em, $request);

        if (!is_array($operations)) {
            return $this->redirectToRoute('app_home');
        } elseif (count($operations) == 0) {
            return $this->render('errors/access_denied.html.twig');
        }
        $modules = $this->em->getRepository(UsModule::class)->findAll();

        return $this->render('pharmacy/bordereaux_validation/index.html.twig', [
            'operations' => $operations,
            'modules' => $modules,
        ]);
    }

    #[Route('/list', name: 'app_pharmacy_brd_list', options: ['expose' => true])]
    public function app_pharmacy_brd_list(Request $request): Response
    {
        $operations = $this->api->check($this->getUser(), 'app_pharmacy_brd', $this->em, $request);
        $filteredActions = array_filter($operations, function($operation) {
            return ($operation->isAlign());
        });
        $allActions = array_map(function($action) {
            return [
                'sousModuleId'=> $action->getSousModule()->getId(),
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
        ->select('brd.id, brd.code as code_brd, brd.created as date, COUNT(livs.id) as livraison_count, brd.observation')
        ->from(BordereauxValidation::class, 'brd')
        ->leftJoin('brd.livraisonStockCabs', 'livs')
        ->groupBy('brd.id');

        if (!empty($search)) {
            $queryBuilder->andWhere('(brd.code LIKE :search OR brd.created LIKE :search)')
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
            ->select('COUNT(brd.id)')
            ->from(BordereauxValidation::class, 'brd')
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
}
