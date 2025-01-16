<?php

namespace App\Entity;

use App\Repository\UFamilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UFamilleRepository::class)]
class UFamille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $designation = null;

    /**
     * @var Collection<int, UArticle>
     */
    #[ORM\OneToMany(targetEntity: UArticle::class, mappedBy: 'famille')]
    private Collection $uArticles;

    public function __construct()
    {
        $this->uArticles = new ArrayCollection();
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

    /**
     * @return Collection<int, UArticle>
     */
    public function getUArticles(): Collection
    {
        return $this->uArticles;
    }

    public function addUArticle(UArticle $uArticle): static
    {
        if (!$this->uArticles->contains($uArticle)) {
            $this->uArticles->add($uArticle);
            $uArticle->setFamille($this);
        }

        return $this;
    }

    public function removeUArticle(UArticle $uArticle): static
    {
        if ($this->uArticles->removeElement($uArticle)) {
            // set the owning side to null (unless already changed)
            if ($uArticle->getFamille() === $this) {
                $uArticle->setFamille(null);
            }
        }

        return $this;
    }
}
