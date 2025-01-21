<?php

namespace App\Entity;

use App\Repository\DemandeStockCabRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeStockCabRepository::class)]
class DemandeStockCab
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'demandeStockCabs')]
    private ?PDossier $demandeur = null;

    #[ORM\ManyToOne(inversedBy: 'demandeStockCabs')]
    private ?PDossier $recepteur = null;

    #[ORM\ManyToOne(inversedBy: 'demandeStockCabs')]
    private ?UPPartenaire $client = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $di = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ipp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $patient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipoFacturac = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dossierPatient = null;

    #[ORM\ManyToOne(inversedBy: 'demandeStockCabs')]
    private ?DemandeStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'demandeStockCabs')]
    private ?CommandeType $commandeType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $observation = null;

    #[ORM\ManyToOne(inversedBy: 'demandeStockCabs')]
    private ?DemandeTypeOp $typeOp = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $refDocAsso = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(nullable: true)]
    private ?int $idAccess = null;

    /**
     * @var Collection<int, DemandeStockDet>
     */
    #[ORM\OneToMany(targetEntity: DemandeStockDet::class, mappedBy: 'demandeCab')]
    private Collection $demandeStockDets;

    /**
     * @var Collection<int, LivraisonStockCab>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockCab::class, mappedBy: 'demande')]
    private Collection $livraisonStockCabs;

    #[ORM\ManyToOne(inversedBy: 'demandeStockCabs')]
    private ?UAntenne $antenneDemandeur = null;

    #[ORM\ManyToOne(inversedBy: 'demandeStockCabs')]
    private ?UAntenne $antenne = null;

    public function __construct()
    {
        $this->demandeStockDets = new ArrayCollection();
        $this->livraisonStockCabs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemandeur(): ?PDossier
    {
        return $this->demandeur;
    }

    public function setDemandeur(?PDossier $demandeur): static
    {
        $this->demandeur = $demandeur;

        return $this;
    }

    public function getRecepteur(): ?PDossier
    {
        return $this->recepteur;
    }

    public function setRecepteur(?PDossier $recepteur): static
    {
        $this->recepteur = $recepteur;

        return $this;
    }

    public function getClient(): ?UPPartenaire
    {
        return $this->client;
    }

    public function setClient(?UPPartenaire $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getDi(): ?string
    {
        return $this->di;
    }

    public function setDi(?string $di): static
    {
        $this->di = $di;

        return $this;
    }

    public function getIpp(): ?string
    {
        return $this->ipp;
    }

    public function setIpp(?string $ipp): static
    {
        $this->ipp = $ipp;

        return $this;
    }

    public function getPatient(): ?string
    {
        return $this->patient;
    }

    public function setPatient(?string $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getTipoFacturac(): ?string
    {
        return $this->tipoFacturac;
    }

    public function setTipoFacturac(?string $tipoFacturac): static
    {
        $this->tipoFacturac = $tipoFacturac;

        return $this;
    }

    public function getDossierPatient(): ?string
    {
        return $this->dossierPatient;
    }

    public function setDossierPatient(?string $dossierPatient): static
    {
        $this->dossierPatient = $dossierPatient;

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

    public function getCommandeType(): ?CommandeType
    {
        return $this->commandeType;
    }

    public function setCommandeType(?CommandeType $commandeType): static
    {
        $this->commandeType = $commandeType;

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

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;

        return $this;
    }

    public function getTypeOp(): ?DemandeTypeOp
    {
        return $this->typeOp;
    }

    public function setTypeOp(?DemandeTypeOp $typeOp): static
    {
        $this->typeOp = $typeOp;

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

    public function getRefDocAsso(): ?string
    {
        return $this->refDocAsso;
    }

    public function setRefDocAsso(?string $refDocAsso): static
    {
        $this->refDocAsso = $refDocAsso;

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
            $demandeStockDet->setDemandeCab($this);
        }

        return $this;
    }

    public function removeDemandeStockDet(DemandeStockDet $demandeStockDet): static
    {
        if ($this->demandeStockDets->removeElement($demandeStockDet)) {
            // set the owning side to null (unless already changed)
            if ($demandeStockDet->getDemandeCab() === $this) {
                $demandeStockDet->setDemandeCab(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LivraisonStockCab>
     */
    public function getLivraisonStockCabs(): Collection
    {
        return $this->livraisonStockCabs;
    }

    public function addLivraisonStockCab(LivraisonStockCab $livraisonStockCab): static
    {
        if (!$this->livraisonStockCabs->contains($livraisonStockCab)) {
            $this->livraisonStockCabs->add($livraisonStockCab);
            $livraisonStockCab->setDemande($this);
        }

        return $this;
    }

    public function removeLivraisonStockCab(LivraisonStockCab $livraisonStockCab): static
    {
        if ($this->livraisonStockCabs->removeElement($livraisonStockCab)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockCab->getDemande() === $this) {
                $livraisonStockCab->setDemande(null);
            }
        }

        return $this;
    }

    public function getAntenneDemandeur(): ?UAntenne
    {
        return $this->antenneDemandeur;
    }

    public function setAntenneDemandeur(?UAntenne $antenneDemandeur): static
    {
        $this->antenneDemandeur = $antenneDemandeur;

        return $this;
    }

    public function getAntenne(): ?UAntenne
    {
        return $this->antenne;
    }

    public function setAntenne(?UAntenne $antenne): static
    {
        $this->antenne = $antenne;

        return $this;
    }
}
