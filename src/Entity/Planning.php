<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PlanningRepository;
use App\State\PlanningProvider;
use App\State\RemoveCollaboratorInPlanningProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: PlanningRepository::class)]
#[ApiResource(
    denormalizationContext: ['groups' => ['write:planning']],
    normalizationContext: ['groups' => ['read:planning']],
    security: 'is_granted(\'ROLE_ADMIN\')',
    operations: [
        new Get(
            security: 'is_granted(\'ROLE_USER\')',
            uriTemplate: '/plannings/details',
            provider: PlanningProvider::class,
        ),
        new Get(),
        new GetCollection(),
        new Post(),
        new Post(
            uriTemplate: '/plannings/{id}/add_collaborators',
            denormalizationContext: ['groups' => ['write:planning_collaborator']],
            requirements: ['id' => '\d+'],
            status: 200,
        ),
        new Put(),
        new Post(
            uriTemplate: '/plannings/{id}/remove_collaborators',
            requirements: ['id' => '\d+'],
            status: 204,
            denormalizationContext: ['groups' => ['write:planning_collaborator']],
            processor: RemoveCollaboratorInPlanningProcessor::class,
            read: false,
        ),
        new Delete(security: "is_granted('REMOVE_PLANNING', object)"),
    ],
)]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:collaborator', 'read:user_leave', 'read:planning'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['write:planning', 'read:planning', 'read:collaborator', 'read:user_leave'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['write:planning', 'read:planning', 'read:collaborator', 'read:user_leave'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'planning', targetEntity: Collaborator::class)]
    #[Groups(['write:planning_collaborator', 'read:planning', 'write:planning_collaborator'])]
    private Collection $collaborators;

    #[ORM\OneToMany(mappedBy: 'planning', targetEntity: Leave::class)]
    #[Groups(['read:planning'])]
    private Collection $leaves;

    public function __construct()
    {
        $this->collaborators = new ArrayCollection();
        $this->leaves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCollaborators(): Collection
    {
        return $this->collaborators;
    }

    public function addCollaborator(Collaborator $collaborator): self
    {
        if (!$this->collaborators->contains($collaborator)) {
            $this->collaborators->add($collaborator);
            $collaborator->setPlanning($this);
        }

        return $this;
    }

    public function removeCollaborator(Collaborator $collaborator): self
    {
        if ($this->collaborators->removeElement($collaborator)) {
            if ($collaborator->getPlanning() === $this) {
                $collaborator->setPlanning(null);
            }
        }

        return $this;
    }

    public function getLeaves(): Collection
    {
        return $this->leaves;
    }

    public function addLeaves(Leave $leave): self
    {
        if (!$this->leaves->contains($leave)) {
            $this->leaves->add($leave);
            $leave->setPlanning($this);
        }

        return $this;
    }

    public function removeLeaves(Leave $leave): self
    {
        if ($this->leaves->removeElement($leave)) {
            if ($leave->getPlanning() === $this) {
                $leave->setPlanning(null);
            }
        }

        return $this;
    }
}
