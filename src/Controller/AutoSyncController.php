<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Users;
use App\Entity\UDepot;
use App\Entity\UAntenne;
use App\Entity\UArticle;
use App\Entity\UFamille;
use App\Entity\Interfacage;
use App\Entity\CommandeType;
use App\Entity\TInscription;
use App\Entity\UPPartenaire;
use App\Entity\DemandeStatus;
use App\Entity\DemandeTypeOp;
use App\Entity\DemandeStockCab;
use App\Entity\DemandeStockDet;
use App\Controller\ApiController;
use App\Entity\LivraisonStockCab;
use App\Entity\LivraisonStockDet;
use App\Entity\InterfacageMissing;
use App\Entity\LivraisonStatus;
use App\Entity\LivraisonStockLot;
use App\Entity\PNaturePrix;
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

#[Route('auto/sync')]
class AutoSyncController extends AbstractController
{
    private $em;
    private $accessDatabaseService;

    public function __construct(AccessDatabaseService $accessDatabaseService,ManagerRegistry $doctrine)
    {
        $this->accessDatabaseService = $accessDatabaseService;
        $this->em = $doctrine->getManager();
        ini_set('max_execution_time', 6000);
        ini_set('memory_limit', '-1');
    }

    #[Route('/', name: 'app_auto_sync')]
    public function index(): Response
    {
        return $this->render('auto_sync/index.html.twig', [
            'controller_name' => 'AutoSyncController',
        ]);
    }

    #[Route('/auto_demande_det', name: 'auto_demande_det', options: ['expose' => true])]
    public function auto_demande_det()
    {
        $access_query = "SELECT  Quantite_CD AS qte, Quantite_SV AS qt_livre, Auto AS id_access FROM pVCommande_LG";

        try {
            return $this->UpdateMydatabase('demande_stock_det', $access_query);
        } catch (\Throwable $th) {
            return new JsonResponse('Erreur de connection..!!', 500);
        }
    }

    public function UpdateMydatabase($table, $access_query)
    {
        $arraydata = $this->accessDatabaseService->query($access_query);
        $newRow = 0;
        $updatedRow = 0;
        // dd($arraydata);
        foreach ($arraydata as $data) {
            $query = "select * from " . $table . " where id_access = " . $data['id_access'] . " limit 1";
            $current_row = $this->selectQuery($query);
            // dd($query);
            if ($current_row) {
                $commonKeys = array_intersect_key($data, $current_row);
                $data = array_intersect_key($data, $commonKeys);
                $current_row = array_intersect_key($current_row, $commonKeys);

                foreach ($commonKeys as $key => $value) {
                    if (is_numeric($data[$key]) && is_numeric($current_row[$key])) {
                        $data[$key] = (float) $data[$key];
                        $current_row[$key] = (float) $current_row[$key];
                    }
                }
                $differences = array_diff_assoc($data, $current_row);


                if ($differences) {
                    // dd($differences);
                    $updated = $this->updateData($data, $table);
                    if ($updated) {
                        $updatedRow++;
                    }
                }
            }else {
                // dd($query);
                $inserted = $this->insertData($data, $table);
                if ($inserted) {
                    $newRow++;
                }
            }
        }
        return new JsonResponse(['updated' => $updatedRow], 200);
    }

    function updateData($dataArray, $table)
    {
        $commonKey = 'id_access';

        $commonKeyValue = $dataArray[$commonKey];

        $setClause = [];
        foreach ($dataArray as $key => $value) {
            // Skip the common key
            if ($key !== $commonKey) {
                if ($value == null) {
                    $setClause[] = "`$key` = " . (is_numeric($value) ? "'" . $value . "'" : "null");
                } else {
                    $setClause[] = "`$key` = '" . $value . "'";
                }
            }
        }

        // Combine the SET clause into a string
        $setClauseString = implode(', ', $setClause);
        // Build the SQL query for the specific row
        $sql = "UPDATE $table SET $setClauseString WHERE $commonKey = $commonKeyValue";
        // dd($sql);
        $stmt = $this->em->getConnection()->prepare($sql);
        // dd($sql);
        $stmt->executeQuery();
        return true;
    }

    function insertData($data, $table)
    {
        $this->insertDemandeDet($data["id_access"]);
        return true;
    }

    public function selectQuery($sqlRequest)
    {
        $stmt = $this->em->getConnection()->prepare($sqlRequest);
        return $stmt->executeQuery()->fetch();
        // return $stmt
    }

    public function insertDemandeDet($id_access){
        $sql = "SELECT lg.Auto, lg.ID_Article, lg.ID_Commande,lg.Quantite_CD, lg.Quantite_SV
        FROM pVCommande_LG lg
        INNER JOIN pVCommande ON lg.ID_Commande = pVCommande.ID_Commande
        WHERE lg.Auto = ".$id_access."
        ORDER BY lg.Auto;";

        $results = $this->accessDatabaseService->query($sql);

        if($results){
            foreach ($results as $result) {
                $demandeCab = $this->em->getRepository(DemandeStockCab::class)->findOneBy(["code" => $result["ID_Commande"]]);
                if(!$demandeCab){
                    continue;
                }

                $article = $this->em->getRepository(UArticle::class)->find($result["ID_Article"]);
                if(!$article){
                    continue;
                }

                $demandeDet = new DemandeStockDet();
                $demandeDet->setIdAccess($result["Auto"]);
                $demandeDet->setArticle($article);
                $demandeDet->setQte($result['Quantite_CD'] ?? 0);
                $demandeDet->setQtLivre($result['Quantite_SV'] ?? 0);
                $demandeDet->setDemandeCab($demandeCab);

                $this->em->persist($demandeDet);
            }

            $this->em->flush();
        }

        return true;
    }
}
