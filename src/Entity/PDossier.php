<?php

namespace App\Entity;

use App\Repository\PDossierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PDossierRepository::class)]
class PDossier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $abreviation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $abreviation2 = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_dossier = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(nullable: true)]
    private ?bool $externe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prefix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    /**
     * @var Collection<int, DemandeStockCab>
     */
    #[ORM\OneToMany(targetEntity: DemandeStockCab::class, mappedBy: 'demandeur')]
    private Collection $demandeStockCabs;

    /**
     * @var Collection<int, UDepot>
     */
    #[ORM\OneToMany(targetEntity: UDepot::class, mappedBy: 'dossier')]
    private Collection $uDepots;

    public function __construct()
    {
        $this->demandeStockCabs = new ArrayCollection();
        $this->uDepots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    public function setAbreviation(?string $abreviation): static
    {
        $this->abreviation = $abreviation;

        return $this;
    }

    public function getAbreviation2(): ?string
    {
        return $this->abreviation2;
    }

    public function setAbreviation2(?string $abreviation2): static
    {
        $this->abreviation2 = $abreviation2;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNomDossier(): ?string
    {
        return $this->nom_dossier;
    }

    public function setNomDossier(?string $nom_dossier): static
    {
        $this->nom_dossier = $nom_dossier;

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

    public function isExterne(): ?bool
    {
        return $this->externe;
    }

    public function setExterne(?bool $externe): static
    {
        $this->externe = $externe;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setPrefix(?string $prefix): static
    {
        $this->prefix = $prefix;

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

    /**
     * @return Collection<int, DemandeStockCab>
     */
    public function getDemandeStockCabs(): Collection
    {
        return $this->demandeStockCabs;
    }

    public function addDemandeStockCab(DemandeStockCab $demandeStockCab): static
    {
        if (!$this->demandeStockCabs->contains($demandeStockCab)) {
            $this->demandeStockCabs->add($demandeStockCab);
            $demandeStockCab->setDemandeur($this);
        }

        return $this;
    }

    public function removeDemandeStockCab(DemandeStockCab $demandeStockCab): static
    {
        if ($this->demandeStockCabs->removeElement($demandeStockCab)) {
            // set the owning side to null (unless already changed)
            if ($demandeStockCab->getDemandeur() === $this) {
                $demandeStockCab->setDemandeur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UDepot>
     */
    public function getUDepots(): Collection
    {
        return $this->uDepots;
    }

    public function addUDepot(UDepot $uDepot): static
    {
        if (!$this->uDepots->contains($uDepot)) {
            $this->uDepots->add($uDepot);
            $uDepot->setDossier($this);
        }

        return $this;
    }

    public function removeUDepot(UDepot $uDepot): static
    {
        if ($this->uDepots->removeElement($uDepot)) {
            // set the owning side to null (unless already changed)
            if ($uDepot->getDossier() === $this) {
                $uDepot->setDossier(null);
            }
        }

        return $this;
    }
}
