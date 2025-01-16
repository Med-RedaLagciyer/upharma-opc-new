<?php

namespace App\Controller;

use App\Entity\UsOperation;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class ApiController extends AbstractController
{
    private $em;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    public function check($user, $link, $em, $request)
    {
        if ($request->getSession()->get("modules") == null) {
            return $this->redirectToRoute('app_home');
        }
        if (in_array('ROLE_SUPERADMIN', $user->getRoles())) {
            $operations = $em->getRepository(UsOperation::class)->findAllBySousModule($link);
            // dd($operations);
            return $operations;
        }
        $operations = $em->getRepository(UsOperation::class)->getOperationByLinkSousModule($user, $link);
        // dd($operations);
        return $operations;
    }
}
