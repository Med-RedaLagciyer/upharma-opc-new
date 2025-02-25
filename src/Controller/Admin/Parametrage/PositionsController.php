<?php

namespace App\Controller\Admin\Parametrage;

use DateTime;
use App\Entity\UsModule;
use App\Entity\ListPosition;
use App\Entity\LivraisonStatus;
use App\Controller\ApiController;
use App\Entity\LivraisonStockCab;
use App\Service\UserActivityLogger;
use App\Entity\LivraisonObservation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/parametrage/positions')]
class PositionsController extends AbstractController
{
    private $em;
    private $api;
    public function __construct(ManagerRegistry $doctrine, ApiController $api)
    {
        $this->em = $doctrine->getManager();
        $this->api = $api;
    }

    #[Route('/', name: 'app_admin_parametrage_positions')]
    public function index(Request $request): Response
    {
        $operations = $this->api->check($this->getUser(), 'app_admin_parametrage_positions', $this->em, $request);

        if (!is_array($operations)) {
            return $this->redirectToRoute('app_home');
        } elseif (count($operations) == 0) {
            return $this->render('errors/access_denied.html.twig');
        }
        $modules = $this->em->getRepository(UsModule::class)->findAll();
        return $this->render('admin/parametrage/positions/index.html.twig', [
            'operations' => $operations,
            'modules' => $modules,
        ]);
    }

    #[Route('/list', name: 'app_admin_parametrage_positions_list', options: ['expose' => true])]
    public function app_admin_parametrage_positions_list(Request $request): Response
    {
        $operations = $this->api->check($this->getUser(), 'app_admin_parametrage_positions', $this->em, $request);
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
            ->select('p.id, p.position, p.isReserved, p.vip, COUNT(livs.id) as count_livs')
            ->from(ListPosition::class, 'p')
            ->leftJoin('p.livraisonStockCabs', 'livs')
            ->groupBy('p.id');
        if (!empty($search)) {
            $queryBuilder->andWhere('(p.position)')
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
            ->select('COUNT(p.id)')
            ->from(ListPosition::class, 'p')
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
