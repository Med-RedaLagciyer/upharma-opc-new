<?php

namespace App\Entity;

use App\Repository\LivraisonStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonStatusRepository::class)]
class LivraisonStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $designation = null;

    /**
     * @var Collection<int, LivraisonStockCab>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockCab::class, mappedBy: 'status')]
    private Collection $livraisonStockCabs;

    public function __construct()
    {
        $this->livraisonStockCabs = new ArrayCollection();
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
            $livraisonStockCab->setStatus($this);
        }

        return $this;
    }

    public function removeLivraisonStockCab(LivraisonStockCab $livraisonStockCab): static
    {
        if ($this->livraisonStockCabs->removeElement($livraisonStockCab)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockCab->getStatus() === $this) {
                $livraisonStockCab->setStatus(null);
            }
        }

        return $this;
    }
}
