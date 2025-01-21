<?php

namespace App\Entity;

use App\Repository\LivraisonStockDetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonStockDetRepository::class)]
class LivraisonStockDet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonStockDets')]
    private ?LivraisonStockCab $livraison = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonStockDets')]
    private ?UArticle $article = null;

    #[ORM\Column(nullable: true)]
    private ?float $quantity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(nullable: true)]
    private ?int $idAccess = null;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivraison(): ?LivraisonStockCab
    {
        return $this->livraison;
    }

    public function setLivraison(?LivraisonStockCab $livraison): static
    {
        $this->livraison = $livraison;

        return $this;
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

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): static
    {
        $this->quantity = $quantity;

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
