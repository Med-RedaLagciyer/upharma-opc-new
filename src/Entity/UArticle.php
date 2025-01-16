<?php

namespace App\Entity;

use App\Repository\UArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UArticleRepository::class)]
class UArticle
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(nullable: true)]
    private ?int $stockMin = null;

    #[ORM\Column(nullable: true)]
    private ?int $stockMax = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeBarre = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(nullable: true)]
    private ?int $idAccess = null;

    #[ORM\ManyToOne(inversedBy: 'uArticles')]
    private ?UFamille $famille = null;

    /**
     * @var Collection<int, DemandeStockDet>
     */
    #[ORM\OneToMany(targetEntity: DemandeStockDet::class, mappedBy: 'article')]
    private Collection $demandeStockDets;

    /**
     * @var Collection<int, LivraisonStockDet>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockDet::class, mappedBy: 'article')]
    private Collection $livraisonStockDets;

    public function __construct()
    {
        $this->demandeStockDets = new ArrayCollection();
        $this->livraisonStockDets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getStockMin(): ?int
    {
        return $this->stockMin;
    }

    public function setStockMin(?int $stockMin): static
    {
        $this->stockMin = $stockMin;

        return $this;
    }

    public function getStockMax(): ?int
    {
        return $this->stockMax;
    }

    public function setStockMax(?int $stockMax): static
    {
        $this->stockMax = $stockMax;

        return $this;
    }

    public function getCodeBarre(): ?string
    {
        return $this->codeBarre;
    }

    public function setCodeBarre(?string $codeBarre): static
    {
        $this->codeBarre = $codeBarre;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): static
    {
        $this->active = $active;

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

    public function getFamille(): ?UFamille
    {
        return $this->famille;
    }

    public function setFamille(?UFamille $famille): static
    {
        $this->famille = $famille;

        return $this;
    }

    /**
     * @return Collection<int, DemandeStockDet>
     */
    public function getDemandeStockDets(): Collection
    {
        return $this->demandeStockDets;
    }

    public function addDemandeStockDet(DemandeStockDet $demandeStockDet): static
    {
        if (!$this->demandeStockDets->contains($demandeStockDet)) {
            $this->demandeStockDets->add($demandeStockDet);
            $demandeStockDet->setArticle($this);
        }

        return $this;
    }

    public function removeDemandeStockDet(DemandeStockDet $demandeStockDet): static
    {
        if ($this->demandeStockDets->removeElement($demandeStockDet)) {
            // set the owning side to null (unless already changed)
            if ($demandeStockDet->getArticle() === $this) {
                $demandeStockDet->setArticle(null);
            }
        }

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
            $livraisonStockDet->setArticle($this);
        }

        return $this;
    }

    public function removeLivraisonStockDet(LivraisonStockDet $livraisonStockDet): static
    {
        if ($this->livraisonStockDets->removeElement($livraisonStockDet)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockDet->getArticle() === $this) {
                $livraisonStockDet->setArticle(null);
            }
        }

        return $this;
    }
}
