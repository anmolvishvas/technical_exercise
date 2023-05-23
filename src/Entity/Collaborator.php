<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\CollaboratorsRepository;
use App\State\CollaboratorStateProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CollaboratorsRepository::class)]
#[ApiResource(
    security: 'is_granted(\'ROLE_ADMIN\')',
    openapiContext: [
        'security' => [['bearerAuth' => []]],
    ],
    operations: [
        new Post(
            uriTemplate: '/collaborators',
            processor: CollaboratorStateProcessor::class,
        ),
        new Patch(),
        new Delete(),
        new GetCollection(),
        new Get(),
    ],
    denormalizationContext: ['groups' => ['collaborator:create']],
    normalizationContext: ['groups' => ['read:Collaborator']],
)]
class Collaborator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Planning', 'read:Collaborator', 'read:Leave', 'user_leave', 'read:planning_colaborators'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['collaborator:create', 'read:Planning', 'read:Collaborator', 'read:Leave', 'user_leave', 'read:planning_colaborators'])]
    private ?string $familyName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['collaborator:create', 'read:Planning', 'read:Collaborator', 'read:Leave', 'user_leave', 'read:planning_colaborators'])]
    private ?string $givenName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['collaborator:create', 'read:Planning', 'read:Collaborator', 'read:Leave', 'user_leave', 'read:planning_colaborators'])]
    private ?string $jobTitle = null;

    #[ORM\ManyToOne(inversedBy: 'collaborators', targetEntity: Planning::class, cascade: ['persist'])]
    #[Groups('read:Collaborator')]
    private ?Planning $planning = null;

    #[ORM\OneToMany(targetEntity: Leave::class, mappedBy: 'collaborators', orphanRemoval: true)]
    private Collection $leaves;

    #[ORM\OneToOne(inversedBy: 'collaborator', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->leaves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(string $givenName): self
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getPlanning(): ?Planning
    {
        return $this->planning;
    }

    public function setPlanning(?Planning $planning): self
    {
        $this->planning = $planning;

        return $this;
    }

    /**
     * @return Collection<int, Leave>
     */
    public function getLeaves(): Collection
    {
        return $this->leaves;
    }

    public function addLeaves(Leave $leave): self
    {
        if (!$this->leaves->contains($leave)) {
            $this->leaves->add($leave);
            $leave->setCollaborator($this);
        }

        return $this;
    }

    public function removeLeave(Leave $leave): self
    {
        $this->leaves->removeElement($leave);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
