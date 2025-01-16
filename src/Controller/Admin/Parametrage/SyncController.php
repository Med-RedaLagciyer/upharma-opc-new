<?php

namespace App\Controller\Admin\Parametrage;

use App\Entity\User;
use App\Entity\Users;
use App\Entity\UArticle;
use App\Entity\UFamille;
use App\Entity\Interfacage;
use App\Entity\TInscription;
use App\Controller\ApiController;
use App\Service\AccessDatabaseService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('admin/parametrage/synchronisation')]
class SyncController extends AbstractController
{
    private $em;
    private $accessDatabaseService;

    public function __construct(AccessDatabaseService $accessDatabaseService, ManagerRegistry $doctrine)
    {
        $this->accessDatabaseService = $accessDatabaseService;
        $this->em = $doctrine->getManager();
        ini_set('max_execution_time', 6000);
        ini_set('memory_limit', '-1');
    }
    #[Route('/', name: 'app_admin_synchronisation', options: ['expose' => true])]
    public function synchronisation(Request $request): Response
    {
        return $this->render('admin/parametrage/sync/index.html.twig', []);
    }
    #[Route('/api_article', name: 'api_article', options: ['expose' => true])]
    public function api_article()
    {
        $insertedCount = 0;

        $lastArticle = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pArticles"]);
        $lastArticleId = $lastArticle ? $lastArticle->getLastId() : 1;

        $sql = "SELECT  TOP 5000 * FROM pArticles WHERE Auto >" . $lastArticleId . " ORDER BY Auto";
        $results = $this->accessDatabaseService->query($sql);
        try {
            if($results){
                foreach ($results as $result) {
                    $articleExist = $this->em->getRepository(UArticle::class)->find($result["ID_Article"]);
                    if($articleExist){
                        continue;
                    }
                    $article = new UArticle();
                    $article->setId($result["ID_Article"]);
                    $article->setCode($result["ID_Article"]);
                    $article->setTitre($result["Article"]);
                    $article->setStockMin($result["Stock_Min"]);
                    $article->setStockMax($result["Stock_Max"]);
                    $article->setCodeBarre($result["CodeBarre"]);
                    $article->setActive(!$result["Desactiver"]);
                    $article->setIdAccess($result["Auto"]);

                    $famille = $this->em->getRepository(UFamille::class)->findOneBy(["code" => $result['ID_Famille']]);
                    if($famille){
                        $article->setFamille($famille);
                    }

                    $this->em->persist($article);
                    $insertedCount++;
                }

                $this->em->flush();

                $lastArticle = $lastArticle ? $lastArticle : new Interfacage();
                $articles = $this->em->getRepository(UArticle::class)->findBy([], ['id' => 'DESC']);
                $lastArticle->setTabelName("pArticles");
                $lastArticle->setLastId($articles[0]->getIdAccess());

                $this->em->persist($lastArticle);
                $this->em->flush();
            }

            return new JsonResponse(['message' => 'Articles inserted successfully.', 'countInserted' => $insertedCount, 'countTotal' => count($articles)], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    #[Route('/api_demande_cab', name: 'api_demande_cab', options: ['expose' => true])]
    public function api_demande_cab()
    {
        $insertedCount = 0;

        $lastArticle = $this->em->getRepository(Interfacage::class)->findOneBy(["tabelName" => "pArticles"]);
        $lastArticleId = $lastArticle ? $lastArticle->getLastId() : 1;

        $sql = "SELECT  TOP 5000 * FROM pArticles WHERE Auto >" . $lastArticleId . " ORDER BY Auto";
        $results = $this->accessDatabaseService->query($sql);
        try {
            if($results){
                foreach ($results as $result) {
                    $articleExist = $this->em->getRepository(UArticle::class)->find($result["ID_Article"]);
                    if($articleExist){
                        continue;
                    }
                    $article = new UArticle();
                    $article->setId($result["ID_Article"]);
                    $article->setCode($result["ID_Article"]);
                    $article->setTitre($result["Article"]);
                    $article->setStockMin($result["Stock_Min"]);
                    $article->setStockMax($result["Stock_Max"]);
                    $article->setCodeBarre($result["CodeBarre"]);
                    $article->setActive(!$result["Desactiver"]);
                    $article->setIdAccess($result["Auto"]);

                    $famille = $this->em->getRepository(UFamille::class)->findOneBy(["code" => $result['ID_Famille']]);
                    if($famille){
                        $article->setFamille($famille);
                    }

                    $this->em->persist($article);
                    $insertedCount++;
                }

                $this->em->flush();

                $lastArticle = $lastArticle ? $lastArticle : new Interfacage();
                $articles = $this->em->getRepository(UArticle::class)->findBy([], ['id' => 'DESC']);
                $lastArticle->setTabelName("pArticles");
                $lastArticle->setLastId($articles[0]->getIdAccess());

                $this->em->persist($lastArticle);
                $this->em->flush();
            }

            return new JsonResponse(['message' => 'Articles inserted successfully.', 'countInserted' => $insertedCount, 'countTotal' => count($articles)], 200);

        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }


}
