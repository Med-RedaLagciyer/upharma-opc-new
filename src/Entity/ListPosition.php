<?php

namespace App\Entity;

use App\Repository\ListPositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListPositionRepository::class)]
class ListPosition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $position = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isReserved = null;

    /**
     * @var Collection<int, LivraisonStockCab>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockCab::class, mappedBy: 'position')]
    private Collection $livraisonStockCabs;

    #[ORM\Column(nullable: true)]
    private ?bool $vip = null;

    public function __construct()
    {
        $this->livraisonStockCabs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function isReserved(): ?bool
    {
        return $this->isReserved;
    }

    public function setReserved(?bool $isReserved): static
    {
        $this->isReserved = $isReserved;

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
            $livraisonStockCab->setPosition($this);
        }

        return $this;
    }

    public function removeLivraisonStockCab(LivraisonStockCab $livraisonStockCab): static
    {
        if ($this->livraisonStockCabs->removeElement($livraisonStockCab)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockCab->getPosition() === $this) {
                $livraisonStockCab->setPosition(null);
            }
        }

        return $this;
    }

    public function isVip(): ?bool
    {
        return $this->vip;
    }

    public function setVip(?bool $vip): static
    {
        $this->vip = $vip;

        return $this;
    }
}
