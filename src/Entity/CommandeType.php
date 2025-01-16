<?php

namespace App\Entity;

use App\Repository\CommandeTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeTypeRepository::class)]
class CommandeType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $designation = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    /**
     * @var Collection<int, DemandeStockCab>
     */
    #[ORM\OneToMany(targetEntity: DemandeStockCab::class, mappedBy: 'commandeType')]
    private Collection $demandeStockCabs;

    public function __construct()
    {
        $this->demandeStockCabs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

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
            $demandeStockCab->setCommandeType($this);
        }

        return $this;
    }

    public function removeDemandeStockCab(DemandeStockCab $demandeStockCab): static
    {
        if ($this->demandeStockCabs->removeElement($demandeStockCab)) {
            // set the owning side to null (unless already changed)
            if ($demandeStockCab->getCommandeType() === $this) {
                $demandeStockCab->setCommandeType(null);
            }
        }

        return $this;
    }
}
