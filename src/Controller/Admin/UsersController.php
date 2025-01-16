<?php

namespace App\Controller\Admin;

use DateTime;
use Mpdf\Mpdf;
use App\Entity\Act;
use App\Entity\User;
use App\Entity\UsModule;
use App\Entity\Rendezvous;
use App\Entity\TAdmission;
use App\Entity\UsOperation;
use App\Entity\TInscription;
use App\Entity\UsSousModule;
use App\Controller\ApiController;
use Doctrine\Persistence\ManagerRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/parametrage/users')]
class UsersController extends AbstractController
{
    private $em;
    private $api;
    public function __construct(ManagerRegistry $doctrine, ApiController $api)
    {
        $this->em = $doctrine->getManager();
        $this->api = $api;
    }

    #[Route('/', name: 'app_admin_parametrage_users')]
    public function index(Request $request): Response
    {
        $operations = $this->api->check($this->getUser(), 'app_admin_parametrage_users', $this->em, $request);
        // dd($operations);
        if (!is_array($operations)) {
            return $this->redirectToRoute('app_home');
        } elseif (count($operations) == 0) {
            return $this->render('errors/access_denied.html.twig',);
        }
        $modules = $this->em->getRepository(UsModule::class)->findAll();
        return $this->render('admin/parametrage/users/index.html.twig', [
            'operations' => $operations,
            'modules' => $modules,
        ]);
    }

    #[Route('/list', name: 'app_admin_parametrage_users_list', options: ['expose' => true])]
    public function app_admin_rdv_listing_list(Request $request): Response
    {
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
            ->select('u.id, u.username, u.nom, u.prenom, u.email, u.roles, u.created, u.enable')
            ->from(User::class, 'u');
        if (!empty($search)) {
            $queryBuilder->andWhere('(u.username LIKE :search OR u.nom LIKE :search OR u.prenom LIKE :search OR u.email LIKE :search OR u.created LIKE :search OR u.roles LIKE :search OR u.created LIKE :search)')
                ->setParameter('search', "%$search%");
        }

        $filteredRecords = count($queryBuilder->getQuery()->getResult());

        // Paginate results
        $queryBuilder->setFirstResult($start)
            ->setMaxResults($length);

        $results = $queryBuilder->getQuery()->getResult();
        // dd($results);
        foreach ($results as &$result) {
            if (is_string($result['roles'])) {
                $result['roles'] = explode(',', trim($result['roles'], '{}'));
            }
        }
        // dd($results);
        $totalRecords = $this->em->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from(User::class, 'u')
            ->andWhere('u.etudiant is null')
            ->getQuery()
            ->getSingleScalarResult();

        return new JsonResponse([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $results,
        ]);
    }

    #[Route('/user_operation/{user}', name: 'app_admin_parametrage_users_operation', options: ['expose' => true])]
    public function app_admin_parametrage_users_operation(User $user): Response
    {
        $ids = [];
        foreach ($user->getOperations() as $operation) {
            array_push($ids, ["id" => $operation->getId()]);
        }
        return new JsonResponse($ids);
    }

    #[Route('/all/{user}/{type}', name: 'app_admin_parametrage_users_all', options: ['expose' => true])]
    public function app_admin_parametrage_users_all(User $user, $type): Response
    {
        $operations = $this->em->getRepository(UsOperation::class)->findAll();
        if ($type === "add") {
            foreach ($operations as $operation) {
                $user->addOperation($operation);
            }
        } else if ($type === "remove") {
            foreach ($operations as $operation) {
                $user->removeOperation($operation);
            }
        } else {
            die("Veuillez contacter l'administrateur !");
        }
        $this->em->flush();
        return new JsonResponse(1);
    }

    #[Route('/sousmodule/{sousModule}/{user}/{type}', name: 'app_admin_parametrage_users_sousmodule', options: ['expose' => true])]
    public function app_admin_parametrage_users_sousmodule(UsSousModule $sousModule, User $user, $type): Response
    {
        if ($type === "add") {
            foreach ($sousModule->getOperations() as $operation) {
                $user->addOperation($operation);
            }
        } else if ($type === "remove") {
            foreach ($sousModule->getOperations() as $operation) {
                $user->removeOperation($operation);
            }
        } else {
            die("Veuillez contacter l'administrateur !");
        }
        $this->em->flush();
        return new JsonResponse(1);
    }

    #[Route('/module/{module}/{user}/{type}', name: 'app_admin_parametrage_users_module', options: ['expose' => true])]
    public function app_admin_parametrage_users_module(UsModule $module, User $user, $type): Response
    {
        if ($type === "add") {
            foreach ($module->getSousModules() as $sousModule) {
                foreach ($sousModule->getOperations() as $operation) {
                    $user->addOperation($operation);
                }
            }
        } else if ($type === "remove") {
            foreach ($module->getSousModules() as $sousModule) {
                foreach ($sousModule->getOperations() as $operation) {
                    $user->removeOperation($operation);
                }
            }
        } else {
            die("Veuillez contacter l'administrateur !");
        }
        $this->em->flush();
        return new JsonResponse(1);
    }

    #[Route('/operation/{operation}/{user}/{type}', name: 'app_admin_parametrage_users_operation_add', options: ['expose' => true])]
    public function app_admin_parametrage_users_operation_add(UsOperation $operation, User $user, $type): Response
    {
        if ($type === "add") {
            $user->addOperation($operation);
        } else if ($type === "remove") {
            $user->removeOperation($operation);
        } else {
            die("Veuillez contacter l'administrateur !");
        }
        $this->em->flush();
        return new JsonResponse(1);
    }

    #[Route('/activer/{user}', name: 'app_parametrage_users_toggle_active', options: ['expose' => true])]
    public function app_parametrage_users_toggle_active(User $user): Response
    {
        $user->setEnable(!$user->isEnable());

        $this->em->flush();
        return new JsonResponse(1);
    }
}
