<?php

namespace App\Entity;

use App\Repository\UDepotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UDepotRepository::class)]
class UDepot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'uDepots')]
    private ?PDossier $dossier = null;

    #[ORM\Column(length: 255)]
    private ?string $sceHosi = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idClient = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $autreInformation = null;

    /**
     * @var Collection<int, UAntenne>
     */
    #[ORM\OneToMany(targetEntity: UAntenne::class, mappedBy: 'depot')]
    private Collection $uAntennes;

    public function __construct()
    {
        $this->uAntennes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDossier(): ?PDossier
    {
        return $this->dossier;
    }

    public function setDossier(?PDossier $dossier): static
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getSceHosi(): ?string
    {
        return $this->sceHosi;
    }

    public function setSceHosi(string $sceHosi): static
    {
        $this->sceHosi = $sceHosi;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): static
    {
        $this->pays = $pays;

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

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getAutreInformation(): ?string
    {
        return $this->autreInformation;
    }

    public function setAutreInformation(?string $autreInformation): static
    {
        $this->autreInformation = $autreInformation;

        return $this;
    }

    /**
     * @return Collection<int, UAntenne>
     */
    public function getUAntennes(): Collection
    {
        return $this->uAntennes;
    }

    public function addUAntenne(UAntenne $uAntenne): static
    {
        if (!$this->uAntennes->contains($uAntenne)) {
            $this->uAntennes->add($uAntenne);
            $uAntenne->setDepot($this);
        }

        return $this;
    }

    public function removeUAntenne(UAntenne $uAntenne): static
    {
        if ($this->uAntennes->removeElement($uAntenne)) {
            // set the owning side to null (unless already changed)
            if ($uAntenne->getDepot() === $this) {
                $uAntenne->setDepot(null);
            }
        }

        return $this;
    }
}
