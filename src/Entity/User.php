<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?bool $enable = true;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created = null;

    #[ORM\ManyToMany(targetEntity: UsOperation::class, mappedBy: 'user')]
    private Collection $operations;

    /**
     * @var Collection<int, LivraisonStockCab>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockCab::class, mappedBy: 'userCreated')]
    private Collection $livraisonStockCabs;

    /**
     * @var Collection<int, BordereauxValidation>
     */
    #[ORM\OneToMany(targetEntity: BordereauxValidation::class, mappedBy: 'userCreated')]
    private Collection $bordereauxValidations;

    /**
     * @var Collection<int, LivraisonStockCab>
     */
    #[ORM\OneToMany(targetEntity: LivraisonStockCab::class, mappedBy: 'userValider')]
    private Collection $livraisonsValider;

    /**
     * @var Collection<int, LivraisonObservation>
     */
    #[ORM\OneToMany(targetEntity: LivraisonObservation::class, mappedBy: 'userCreated')]
    private Collection $livraisonObservations;

    public function __construct()
    {
        $this->livraisonStockCabs = new ArrayCollection();
        $this->bordereauxValidations = new ArrayCollection();
        $this->livraisonsValider = new ArrayCollection();
        $this->livraisonObservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function isEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

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

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Collection<int, UsOperation>
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    public function addOperation(UsOperation $operation): static
    {
        if (!$this->operations->contains($operation)) {
            $this->operations->add($operation);
            $operation->addUser($this);
        }

        return $this;
    }

    public function removeOperation(UsOperation $operation): static
    {
        if ($this->operations->removeElement($operation)) {
            $operation->removeUser($this);
        }

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
            $livraisonStockCab->setUserCreated($this);
        }

        return $this;
    }

    public function removeLivraisonStockCab(LivraisonStockCab $livraisonStockCab): static
    {
        if ($this->livraisonStockCabs->removeElement($livraisonStockCab)) {
            // set the owning side to null (unless already changed)
            if ($livraisonStockCab->getUserCreated() === $this) {
                $livraisonStockCab->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BordereauxValidation>
     */
    public function getBordereauxValidations(): Collection
    {
        return $this->bordereauxValidations;
    }

    public function addBordereauxValidation(BordereauxValidation $bordereauxValidation): static
    {
        if (!$this->bordereauxValidations->contains($bordereauxValidation)) {
            $this->bordereauxValidations->add($bordereauxValidation);
            $bordereauxValidation->setUserCreated($this);
        }

        return $this;
    }

    public function removeBordereauxValidation(BordereauxValidation $bordereauxValidation): static
    {
        if ($this->bordereauxValidations->removeElement($bordereauxValidation)) {
            // set the owning side to null (unless already changed)
            if ($bordereauxValidation->getUserCreated() === $this) {
                $bordereauxValidation->setUserCreated(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LivraisonStockCab>
     */
    public function getLivraisonsValider(): Collection
    {
        return $this->livraisonsValider;
    }

    public function addLivraisonsValider(LivraisonStockCab $livraisonsValider): static
    {
        if (!$this->livraisonsValider->contains($livraisonsValider)) {
            $this->livraisonsValider->add($livraisonsValider);
            $livraisonsValider->setUserValider($this);
        }

        return $this;
    }

    public function removeLivraisonsValider(LivraisonStockCab $livraisonsValider): static
    {
        if ($this->livraisonsValider->removeElement($livraisonsValider)) {
            // set the owning side to null (unless already changed)
            if ($livraisonsValider->getUserValider() === $this) {
                $livraisonsValider->setUserValider(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LivraisonObservation>
     */
    public function getLivraisonObservations(): Collection
    {
        return $this->livraisonObservations;
    }

    public function addLivraisonObservation(LivraisonObservation $livraisonObservation): static
    {
        if (!$this->livraisonObservations->contains($livraisonObservation)) {
            $this->livraisonObservations->add($livraisonObservation);
            $livraisonObservation->setUserCreated($this);
        }

        return $this;
    }

    public function removeLivraisonObservation(LivraisonObservation $livraisonObservation): static
    {
        if ($this->livraisonObservations->removeElement($livraisonObservation)) {
            // set the owning side to null (unless already changed)
            if ($livraisonObservation->getUserCreated() === $this) {
                $livraisonObservation->setUserCreated(null);
            }
        }

        return $this;
    }
}
