<?php

namespace App\Entity;

use App\Repository\UserStatusLogsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserStatusLogsRepository::class)]
class UserStatusLogs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userStatusLogs')]
    private ?LivraisonStockCab $livraison = null;

    #[ORM\ManyToOne(inversedBy: 'userStatusLogs')]
    private ?LivraisonStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'userStatusLogs')]
    private ?User $userCreated = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivraison(): ?LivraisonStockCab
    {
        return $this->livraison;
    }

    public function setLivraison(?LivraisonStockCab $livraison): static
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getStatus(): ?LivraisonStatus
    {
        return $this->status;
    }

    public function setStatus(?LivraisonStatus $status): static
    {
        $this->status = $status;

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }
}
