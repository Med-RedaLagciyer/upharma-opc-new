<?php

namespace App\Entity;

use App\Repository\DemandeStockDetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeStockDetRepository::class)]
class DemandeStockDet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'demandeStockDets')]
    private ?UArticle $article = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\Column(nullable: true)]
    private ?float $qte = null;

    #[ORM\ManyToOne(inversedBy: 'demandeStockDets')]
    private ?DemandeStockCab $demandeCab = null;

    #[ORM\Column(nullable: true)]
    private ?float $qtLivre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conditionnement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $conditionnementLivre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datePeremption = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixVenteTtc = null;

    #[ORM\Column(nullable: true)]
    private ?float $tva = null;

    #[ORM\Column(nullable: true)]
    private ?float $prixAchatHt = null;

    #[ORM\Column(nullable: true)]
    private ?int $idAccess = null;

    #[ORM\Column(nullable: true)]
    private ?int $lignCd = null;

    /**
     * @var Collection<int, LivraisonStockDet>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockDet::class, mappedBy: 'demandeDet')]
    private Collection $livraisonStockDets;

    public function __construct()
    {
        $this->livraisonStockDets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?UArticle
    {
        return $this->article;
    }

    public function setArticle(?UArticle $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQte(): ?float
    {
        return $this->qte;
    }

    public function setQte(?float $qte): static
    {
        $this->qte = $qte;

        return $this;
    }

    public function getDemandeCab(): ?DemandeStockCab
    {
        return $this->demandeCab;
    }

    public function setDemandeCab(?DemandeStockCab $demandeCab): static
    {
        $this->demandeCab = $demandeCab;

        return $this;
    }

    public function getQtLivre(): ?float
    {
        return $this->qtLivre;
    }

    public function setQtLivre(?float $qtLivre): static
    {
        $this->qtLivre = $qtLivre;

        return $this;
    }

    public function getConditionnement(): ?string
    {
        return $this->conditionnement;
    }

    public function setConditionnement(?string $conditionnement): static
    {
        $this->conditionnement = $conditionnement;

        return $this;
    }

    public function getConditionnementLivre(): ?string
    {
        return $this->conditionnementLivre;
    }

    public function setConditionnementLivre(?string $conditionnementLivre): static
    {
        $this->conditionnementLivre = $conditionnementLivre;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;

        return $this;
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

    public function getIdAccess(): ?int
    {
        return $this->idAccess;
    }

    public function setIdAccess(?int $idAccess): static
    {
        $this->idAccess = $idAccess;

        return $this;
    }

    public function getLignCd(): ?int
    {
        return $this->lignCd;
    }

    public function setLignCd(?int $lignCd): static
    {
        $this->lignCd = $lignCd;

        return $this;
    }

    /**
     * @return Collection<int, LivraisonStockDet>
     */
    public function getLivraisonStockDets(): Collection
    {
        return $this->livraisonStockDets;
    }

    public function addLivraisonStockDet(LivraisonStockDet $livraisonStockDet): static
    {
        if (!$this->livraisonStockDets->contains($livraisonStockDet)) {
            $this->livraisonStockDets->add($livraisonStockDet);
            $livraisonStockDet->setDemandeDet($this);
        }

        return $this;
    }

    public function removeLivraisonStockDet(LivraisonStockDet $livraisonStockDet): static
    {
        if ($this->livraisonStockDets->removeElement($livraisonStockDet)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockDet->getDemandeDet() === $this) {
                $livraisonStockDet->setDemandeDet(null);
            }
        }

        return $this;
    }
}
