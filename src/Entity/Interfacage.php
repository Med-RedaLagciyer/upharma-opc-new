<?php

namespace App\Entity;

use App\Repository\InterfacageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterfacageRepository::class)]
class Interfacage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tabelName = null;

    #[ORM\Column(nullable: true)]
    private ?int $lastId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTabelName(): ?string
    {
        return $this->tabelName;
    }

    public function setTabelName(?string $tabelName): static
    {
        $this->tabelName = $tabelName;

        return $this;
    }

    public function getLastId(): ?int
    {
        return $this->lastId;
    }

    public function setLastId(?int $lastId): static
    {
        $this->lastId = $lastId;

        return $this;
    }
}
