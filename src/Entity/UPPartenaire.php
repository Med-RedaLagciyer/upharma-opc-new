<?php

namespace App\Entity;

use App\Repository\UPPartenaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UPPartenaireRepository::class)]
class UPPartenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'uPPartenaires')]
    private ?UPPartenaireTy $UPPartenaireTy = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $societe = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tel3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fax1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fax2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mail2 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $active = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUPPartenaireTy(): ?UPPartenaireTy
    {
        return $this->UPPartenaireTy;
    }

    public function setUPPartenaireTy(?UPPartenaireTy $UPPartenaireTy): static
    {
        $this->UPPartenaireTy = $UPPartenaireTy;

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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSociete(): ?string
    {
        return $this->societe;
    }

    public function setSociete(?string $societe): static
    {
        $this->societe = $societe;

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

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): static
    {
        $this->pays = $pays;

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

    public function getTel1(): ?string
    {
        return $this->tel1;
    }

    public function setTel1(?string $tel1): static
    {
        $this->tel1 = $tel1;

        return $this;
    }

    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    public function setTel2(?string $tel2): static
    {
        $this->tel2 = $tel2;

        return $this;
    }

    public function getTel3(): ?string
    {
        return $this->tel3;
    }

    public function setTel3(?string $tel3): static
    {
        $this->tel3 = $tel3;

        return $this;
    }

    public function getFax1(): ?string
    {
        return $this->fax1;
    }

    public function setFax1(?string $fax1): static
    {
        $this->fax1 = $fax1;

        return $this;
    }

    public function getFax2(): ?string
    {
        return $this->fax2;
    }

    public function setFax2(?string $fax2): static
    {
        $this->fax2 = $fax2;

        return $this;
    }

    public function getMail1(): ?string
    {
        return $this->mail1;
    }

    public function setMail1(?string $mail1): static
    {
        $this->mail1 = $mail1;

        return $this;
    }

    public function getMail2(): ?string
    {
        return $this->mail2;
    }

    public function setMail2(?string $mail2): static
    {
        $this->mail2 = $mail2;

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

    public function getIce(): ?string
    {
        return $this->ice;
    }

    public function setIce(?string $ice): static
    {
        $this->ice = $ice;

        return $this;
    }
}
