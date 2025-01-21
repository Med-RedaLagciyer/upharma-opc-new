<?php

namespace App\Entity;

use App\Repository\UAntenneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UAntenneRepository::class)]
class UAntenne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $magHosi = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idClient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $designation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $defaut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\Column(nullable: true)]
    private ?int $pharmacyCentraleFlag = null;

    #[ORM\ManyToOne(inversedBy: 'uAntennes')]
    private ?UDepot $depot = null;

    /**
     * @var Collection<int, DemandeStockCab>
     */
    #[ORM\OneToMany(targetEntity: DemandeStockCab::class, mappedBy: 'antenneDemandeur')]
    private Collection $demandeStockCabs;

    public function __construct()
    {
        $this->demandeStockCabs = new ArrayCollection();
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

    public function getMagHosi(): ?string
    {
        return $this->magHosi;
    }

    public function setMagHosi(?string $magHosi): static
    {
        $this->magHosi = $magHosi;

        return $this;
    }

    public function getIdClient(): ?string
    {
        return $this->idClient;
    }

    public function setIdClient(?string $idClient): static
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function isDefaut(): ?bool
    {
        return $this->defaut;
    }

    public function setDefaut(?bool $defaut): static
    {
        $this->defaut = $defaut;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): static
    {
        $this->updated = $updated;

        return $this;
    }

    public function getPharmacyCentraleFlag(): ?int
    {
        return $this->pharmacyCentraleFlag;
    }

    public function setPharmacyCentraleFlag(?int $pharmacyCentraleFlag): static
    {
        $this->pharmacyCentraleFlag = $pharmacyCentraleFlag;

        return $this;
    }

    public function getDepot(): ?UDepot
    {
        return $this->depot;
    }

    public function setDepot(?UDepot $depot): static
    {
        $this->depot = $depot;

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
            $demandeStockCab->setAntenneDemandeur($this);
        }

        return $this;
    }

    public function removeDemandeStockCab(DemandeStockCab $demandeStockCab): static
    {
        if ($this->demandeStockCabs->removeElement($demandeStockCab)) {
            // set the owning side to null (unless already changed)
            if ($demandeStockCab->getAntenneDemandeur() === $this) {
                $demandeStockCab->setAntenneDemandeur(null);
            }
        }

        return $this;
    }
}
