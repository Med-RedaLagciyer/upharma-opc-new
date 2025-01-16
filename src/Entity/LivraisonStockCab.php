<?php

namespace App\Entity;

use App\Repository\LivraisonStockCabRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonStockCabRepository::class)]
class LivraisonStockCab
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonStockCabs')]
    private ?DemandeStockCab $demande = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonStockCabs')]
    private ?DemandeStatus $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(nullable: true)]
    private ?float $urgent = null;

    #[ORM\Column(nullable: true)]
    private ?float $mhTotal = null;

    #[ORM\Column(nullable: true)]
    private ?float $mrTotal = null;

    #[ORM\Column(nullable: true)]
    private ?float $mtvaTotal = null;

    #[ORM\Column(nullable: true)]
    private ?float $mttTotal = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonStockCabs')]
    private ?User $userCreated = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $print = null;

    #[ORM\Column(nullable: true)]
    private ?bool $valide = null;

    /**
     * @var Collection<int, LivraisonStockDet>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockDet::class, mappedBy: 'livraison')]
    private Collection $livraisonStockDets;

    #[ORM\Column(nullable: true)]
    private ?int $idAccess = null;

    public function __construct()
    {
        $this->livraisonStockDets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemande(): ?DemandeStockCab
    {
        return $this->demande;
    }

    public function setDemande(?DemandeStockCab $demande): static
    {
        $this->demande = $demande;

        return $this;
    }

    public function getStatus(): ?DemandeStatus
    {
        return $this->status;
    }

    public function setStatus(?DemandeStatus $status): static
    {
        $this->status = $status;

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

    public function getUrgent(): ?float
    {
        return $this->urgent;
    }

    public function setUrgent(?float $urgent): static
    {
        $this->urgent = $urgent;

        return $this;
    }

    public function getMhTotal(): ?float
    {
        return $this->mhTotal;
    }

    public function setMhTotal(?float $mhTotal): static
    {
        $this->mhTotal = $mhTotal;

        return $this;
    }

    public function getMrTotal(): ?float
    {
        return $this->mrTotal;
    }

    public function setMrTotal(?float $mrTotal): static
    {
        $this->mrTotal = $mrTotal;

        return $this;
    }

    public function getMtvaTotal(): ?float
    {
        return $this->mtvaTotal;
    }

    public function setMtvaTotal(?float $mtvaTotal): static
    {
        $this->mtvaTotal = $mtvaTotal;

        return $this;
    }

    public function getMttTotal(): ?float
    {
        return $this->mttTotal;
    }

    public function setMttTotal(?float $mttTotal): static
    {
        $this->mttTotal = $mttTotal;

        return $this;
    }

    public function getUserCreated(): ?User
    {
        return $this->userCreated;
    }

    public function setUserCreated(?User $userCreated): static
    {
        $this->userCreated = $userCreated;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getPrint(): ?string
    {
        return $this->print;
    }

    public function setPrint(?string $print): static
    {
        $this->print = $print;

        return $this;
    }

    public function isValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): static
    {
        $this->valide = $valide;

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
            $livraisonStockDet->setLivraison($this);
        }

        return $this;
    }

    public function removeLivraisonStockDet(LivraisonStockDet $livraisonStockDet): static
    {
        if ($this->livraisonStockDets->removeElement($livraisonStockDet)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockDet->getLivraison() === $this) {
                $livraisonStockDet->setLivraison(null);
            }
        }

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
