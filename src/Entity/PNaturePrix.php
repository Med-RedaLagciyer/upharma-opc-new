<?php

namespace App\Entity;

use App\Repository\PNaturePrixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PNaturePrixRepository::class)]
class PNaturePrix
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $designation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    /**
     * @var Collection<int, LivraisonStockLot>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockLot::class, mappedBy: 'naturePrix')]
    private Collection $livraisonStockLots;

    public function __construct()
    {
        $this->livraisonStockLots = new ArrayCollection();
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

    public function setActive(?bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, LivraisonStockLot>
     */
    public function getLivraisonStockLots(): Collection
    {
        return $this->livraisonStockLots;
    }

    public function addLivraisonStockLot(LivraisonStockLot $livraisonStockLot): static
    {
        if (!$this->livraisonStockLots->contains($livraisonStockLot)) {
            $this->livraisonStockLots->add($livraisonStockLot);
            $livraisonStockLot->setNaturePrix($this);
        }

        return $this;
    }

    public function removeLivraisonStockLot(LivraisonStockLot $livraisonStockLot): static
    {
        if ($this->livraisonStockLots->removeElement($livraisonStockLot)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockLot->getNaturePrix() === $this) {
                $livraisonStockLot->setNaturePrix(null);
            }
        }

        return $this;
    }
}
