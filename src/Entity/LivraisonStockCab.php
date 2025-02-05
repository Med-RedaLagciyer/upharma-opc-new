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

    /**
     * @var Collection<int, LivraisonStockLot>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockLot::class, mappedBy: 'livraison')]
    private Collection $livraisonStockLot;

    /**
     * @var Collection<int, LivraisonStockDet>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockDet::class, mappedBy: 'livraison')]
    private Collection $livraisonStockDets;

    #[ORM\Column(nullable: true)]
    private ?int $idAccess = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'livraisonStockCabs')]
    private ?self $idReference = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'idReference')]
    private Collection $livraisonStockCabs;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonStockCabs')]
    private ?ListPosition $position = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonStockCabs')]
    private ?ListPosition $positionHistorique = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonStockCabs')]
    private ?LivraisonStatus $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateValidation = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonsValider')]
    private ?User $userValider = null;

    #[ORM\ManyToOne(inversedBy: 'livraisonStockCabs')]
    private ?BordereauxValidation $bordereauxValidation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isValide = null;

    /**
     * @var Collection<int, LivraisonObservation>
     */
    #[ORM\OneToMany(targetEntity: LivraisonObservation::class, mappedBy: 'livraison')]
    private Collection $livraisonObservations;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateFuture = null;

    public function __construct()
    {
        $this->livraisonStockDets = new ArrayCollection();
        $this->livraisonStockCabs = new ArrayCollection();
        $this->livraisonStockLot = new ArrayCollection();
        $this->livraisonObservations = new ArrayCollection();
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

    public function getIdReference(): ?self
    {
        return $this->idReference;
    }

    public function setIdReference(?self $idReference): static
    {
        $this->idReference = $idReference;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getLivraisonStockCabs(): Collection
    {
        return $this->livraisonStockCabs;
    }

    public function addLivraisonStockCab(self $livraisonStockCab): static
    {
        if (!$this->livraisonStockCabs->contains($livraisonStockCab)) {
            $this->livraisonStockCabs->add($livraisonStockCab);
            $livraisonStockCab->setIdReference($this);
        }

        return $this;
    }

    public function removeLivraisonStockCab(self $livraisonStockCab): static
    {
        if ($this->livraisonStockCabs->removeElement($livraisonStockCab)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockCab->getIdReference() === $this) {
                $livraisonStockCab->setIdReference(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LivraisonStockLot>
     */
    public function getLivraisonStockLot(): Collection
    {
        return $this->livraisonStockLot;
    }

    public function addLivraisonStockLot(LivraisonStockLot $livraisonStockLot): static
    {
        if (!$this->livraisonStockLot->contains($livraisonStockLot)) {
            $this->livraisonStockLot->add($livraisonStockLot);
            $livraisonStockLot->setLivraisonCab($this);
        }

        return $this;
    }

    public function removeLivraisonStockLot(LivraisonStockLot $livraisonStockLot): static
    {
        if ($this->livraisonStockLot->removeElement($livraisonStockLot)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockLot->getLivraisonCab() === $this) {
                $livraisonStockLot->setLivraisonCab(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getPosition(): ?ListPosition
    {
        return $this->position;
    }

    public function setPosition(?ListPosition $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getPositionHistorique(): ?ListPosition
    {
        return $this->positionHistorique;
    }

    public function setPositionHistorique(?ListPosition $positionHistorique): static
    {
        $this->positionHistorique = $positionHistorique;

        return $this;
    }

    public function getStatus(): ?LivraisonStatus
    {
        return $this->status;
    }

    public function setStatus(?LivraisonStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->dateValidation;
    }

    public function setDateValidation(?\DateTimeInterface $dateValidation): static
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    public function getUserValider(): ?User
    {
        return $this->userValider;
    }

    public function setUserValider(?User $userValider): static
    {
        $this->userValider = $userValider;

        return $this;
    }

    public function getBordereauxValidation(): ?BordereauxValidation
    {
        return $this->bordereauxValidation;
    }

    public function setBordereauxValidation(?BordereauxValidation $bordereauxValidation): static
    {
        $this->bordereauxValidation = $bordereauxValidation;

        return $this;
    }

    public function isValide(): ?bool
    {
        return $this->isValide;
    }

    public function setValide(?bool $isValide): static
    {
        $this->isValide = $isValide;

        return $this;
    }

    /**
     * @return Collection<int, LivraisonObservation>
     */
    public function getLivraisonObservations(): Collection
    {
        return $this->livraisonObservations;
    }

    public function addLivraisonObservation(LivraisonObservation $livraisonObservation): static
    {
        if (!$this->livraisonObservations->contains($livraisonObservation)) {
            $this->livraisonObservations->add($livraisonObservation);
            $livraisonObservation->setLivraison($this);
        }

        return $this;
    }

    public function removeLivraisonObservation(LivraisonObservation $livraisonObservation): static
    {
        if ($this->livraisonObservations->removeElement($livraisonObservation)) {
            // set the owning side to null (unless already changed)
            if ($livraisonObservation->getLivraison() === $this) {
                $livraisonObservation->setLivraison(null);
            }
        }

        return $this;
    }

    public function getDateFuture(): ?\DateTimeInterface
    {
        return $this->dateFuture;
    }

    public function setDateFuture(?\DateTimeInterface $dateFuture): static
    {
        $this->dateFuture = $dateFuture;

        return $this;
    }
}
