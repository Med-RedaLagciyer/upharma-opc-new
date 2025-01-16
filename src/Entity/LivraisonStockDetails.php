<?php

namespace App\Entity;

use App\Repository\LivraisonStockDetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonStockDetailsRepository::class)]
class LivraisonStockDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePeremption = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantite = null;

    #[ORM\Column(nullable: true)]
    private ?float $quantiteRetour = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixVenteTtc = null;

    #[ORM\Column(nullable: true)]
    private ?float $tva = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixAchatHt = null;

    #[ORM\Column(nullable: true)]
    private ?float $mh = null;

    #[ORM\Column(nullable: true)]
    private ?float $mr = null;

    #[ORM\Column(nullable: true)]
    private ?float $mtva = null;

    #[ORM\Column(nullable: true)]
    private ?float $mtt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateSys = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonStockDetails')]
    private ?LivraisonStockDet $livraisonDet = null;

    #[ORM\Column(nullable: true)]
    private ?float $montant = null;

    #[ORM\Column(nullable: true)]
    private ?float $valeurA = null;

    #[ORM\Column(nullable: true)]
    private ?float $merge = null;

    #[ORM\Column(nullable: true)]
    private ?int $idAccess = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLot(): ?string
    {
        return $this->lot;
    }

    public function setLot(?string $lot): static
    {
        $this->lot = $lot;

        return $this;
    }

    public function getDatePeremption(): ?\DateTimeInterface
    {
        return $this->datePeremption;
    }

    public function setDatePeremption(?\DateTimeInterface $datePeremption): static
    {
        $this->datePeremption = $datePeremption;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getQuantiteRetour(): ?float
    {
        return $this->quantiteRetour;
    }

    public function setQuantiteRetour(?float $quantiteRetour): static
    {
        $this->quantiteRetour = $quantiteRetour;

        return $this;
    }

    public function getPrixVenteTtc(): ?float
    {
        return $this->prixVenteTtc;
    }

    public function setPrixVenteTtc(?float $prixVenteTtc): static
    {
        $this->prixVenteTtc = $prixVenteTtc;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function getPrixAchatHt(): ?float
    {
        return $this->prixAchatHt;
    }

    public function setPrixAchatHt(?float $prixAchatHt): static
    {
        $this->prixAchatHt = $prixAchatHt;

        return $this;
    }

    public function getMh(): ?float
    {
        return $this->mh;
    }

    public function setMh(?float $mh): static
    {
        $this->mh = $mh;

        return $this;
    }

    public function getMr(): ?float
    {
        return $this->mr;
    }

    public function setMr(?float $mr): static
    {
        $this->mr = $mr;

        return $this;
    }

    public function getMtva(): ?float
    {
        return $this->mtva;
    }

    public function setMtva(?float $mtva): static
    {
        $this->mtva = $mtva;

        return $this;
    }

    public function getMtt(): ?float
    {
        return $this->mtt;
    }

    public function setMtt(?float $mtt): static
    {
        $this->mtt = $mtt;

        return $this;
    }

    public function getDateSys(): ?\DateTimeInterface
    {
        return $this->dateSys;
    }

    public function setDateSys(?\DateTimeInterface $dateSys): static
    {
        $this->dateSys = $dateSys;

        return $this;
    }

    public function getLivraisonDet(): ?LivraisonStockDet
    {
        return $this->livraisonDet;
    }

    public function setLivraisonDet(?LivraisonStockDet $livraisonDet): static
    {
        $this->livraisonDet = $livraisonDet;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getValeurA(): ?float
    {
        return $this->valeurA;
    }

    public function setValeurA(?float $valeurA): static
    {
        $this->valeurA = $valeurA;

        return $this;
    }

    public function getMerge(): ?float
    {
        return $this->merge;
    }

    public function setMerge(?float $merge): static
    {
        $this->merge = $merge;

        return $this;
    }

    public function getIdAccess(): ?int
    {
        return $this->idAccess;
    }

    public function setIdAccess(?int $idAccess): static
    {
        $this->idAccess = $idAccess;

        return $this;
    }
}
