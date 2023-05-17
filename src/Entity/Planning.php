<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\PlanningRepository;
use App\State\RemoveCollaboratorInPlanningProcessor;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\HasLifecycleCallbacks]

#[ORM\Entity(repositoryClass: PlanningRepository::class)]
#[ApiResource(
    denormalizationContext: ['groups' => ['planning_create']],
    normalizationContext: ['groups' => ['read:Planning']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Post(
            uriTemplate: '/planning/{id}/add_collaborators',
            requirements: ['id' => '\d+'],
            status: 200,
            denormalizationContext: ['groups' => ['planning_createCollaborator']]
        ),
        new Patch(),
        new Post(
            uriTemplate: '/planning/{id}/remove_collaborators',
            requirements: ['id' => '\d+'],
            status: 204,
            denormalizationContext: ['groups' => ['planning_removeCollaborator']],
            processor: RemoveCollaboratorInPlanningProcessor::class,
            read:false
        ),
        new Delete(security: "is_granted('REMOVE_PLANNING', object)"),
    ]
)]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Collaborator'])] 
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['planning_create', 'read:Planning', 'read:Collaborator'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['planning_create', 'read:Planning', 'read:Collaborator'])]
    private ?string $description = null;


    #[ORM\OneToMany(mappedBy: 'planning', targetEntity: Collaborator::class)]
    #[Groups(['planning_createCollaborator', 'read:Planning', 'planning_removeCollaborator'])]
    private Collection $collaborators;

    public function __construct() {
        $this ->collaborators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Collaborator>
     */
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
    
    /**
     * Removes a collaborator from the planning.
     * Note: The planning can only be removed if there are no assigned collaborators.
     * Make sure to check permission using the REMOVE_PLANNING attribute with the PlanningVoter before removing.
     */
    public function removeCollaborator(Collaborator $collaborator): self
    {
        
        if ($this->collaborators->removeElement($collaborator)) {
            // set the owning side to null (unless already changed)
            if ($collaborator->getPlanning() === $this) {
                $collaborator->setPlanning(null);
            }
        }

        return $this;
    }
}
