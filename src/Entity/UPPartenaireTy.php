<?php

namespace App\Entity;

use App\Repository\UPPartenaireTyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UPPartenaireTyRepository::class)]
class UPPartenaireTy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $abreviation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $designation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    /**
     * @var Collection<int, UPPartenaire>
     */
    #[ORM\OneToMany(targetEntity: UPPartenaire::class, mappedBy: 'UPPartenaireTy')]
    private Collection $uPPartenaires;

    public function __construct()
    {
        $this->uPPartenaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, UPPartenaire>
     */
    public function getUPPartenaires(): Collection
    {
        return $this->uPPartenaires;
    }

    public function addUPPartenaire(UPPartenaire $uPPartenaire): static
    {
        if (!$this->uPPartenaires->contains($uPPartenaire)) {
            $this->uPPartenaires->add($uPPartenaire);
            $uPPartenaire->setUPPartenaireTy($this);
        }

        return $this;
    }

    public function removeUPPartenaire(UPPartenaire $uPPartenaire): static
    {
        if ($this->uPPartenaires->removeElement($uPPartenaire)) {
            // set the owning side to null (unless already changed)
            if ($uPPartenaire->getUPPartenaireTy() === $this) {
                $uPPartenaire->setUPPartenaireTy(null);
            }
        }

        return $this;
    }
}
