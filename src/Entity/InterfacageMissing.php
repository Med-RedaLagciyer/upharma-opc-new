<?php

namespace App\Entity;

use App\Repository\InterfacageMissingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterfacageMissingRepository::class)]
class InterfacageMissing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tableName = null;

    #[ORM\Column(nullable: true)]
    private ?bool $traite = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $identifiant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTableName(): ?string
    {
        return $this->tableName;
    }

    public function setTableName(?string $tableName): static
    {
        $this->tableName = $tableName;

        return $this;
    }

    public function isTraite(): ?bool
    {
        return $this->traite;
    }

    public function setTraite(?bool $traite): static
    {
        $this->traite = $traite;

        return $this;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(?string $identifiant): static
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

        return $this;
    }
}
