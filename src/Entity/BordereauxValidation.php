<?php

namespace App\Entity;

use App\Repository\BordereauxValidationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BordereauxValidationRepository::class)]
class BordereauxValidation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created = null;

    #[ORM\ManyToOne(inversedBy: 'bordereauxValidations')]
    private ?User $userCreated = null;

    /**
     * @var Collection<int, LivraisonStockCab>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockCab::class, mappedBy: 'bordereauxValidation')]
    private Collection $livraisonStockCabs;

    public function __construct()
    {
        $this->livraisonStockCabs = new ArrayCollection();
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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): static
    {
        $this->created = $created;

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
            $livraisonStockCab->setBordereauxValidation($this);
        }

        return $this;
    }

    public function removeLivraisonStockCab(LivraisonStockCab $livraisonStockCab): static
    {
        if ($this->livraisonStockCabs->removeElement($livraisonStockCab)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockCab->getBordereauxValidation() === $this) {
                $livraisonStockCab->setBordereauxValidation(null);
            }
        }

        return $this;
    }
}
