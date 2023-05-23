<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Controller\UserController;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
            new Get(
                paginationEnabled: false,
                uriTemplate: '/users',
                controller: UserController::class,
                read: false,
                security: 'is_granted(\'ROLE_USER\')',
                openapiContext: [
                    'security' => [['bearerAuth' => []]],
                ],
                normalizationContext: ['groups' => ['read:user']],
            ),
        ],
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:user'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['read:user'])]
    private ?string $username = null;

    #[ORM\Column(type: 'json')]
    #[Groups(['read:user'])]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'user')]
    private ?Collaborator $collaborator = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public static function createFromPayload($id, array $payload)
    {
        return (new self())
            ->setId(intval($id))
            ->setUsername($payload['username'])
            ->setRoles($payload['roles'])
        ;
    }

    public function getCollaborator(): ?Collaborator
    {
        return $this->collaborator;
    }

    public function setCollaborator(?Collaborator $collaborator): self
    {
        if (null === $collaborator && null !== $this->collaborator) {
            $this->collaborator->setUser(null);
        }

        if (null !== $collaborator && $collaborator->getUser() !== $this) {
            $collaborator->setUser($this);
        }

        $this->collaborator = $collaborator;

        return $this;
    }
}
