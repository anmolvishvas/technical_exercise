<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PlanningRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PlanningRepository::class)]
#[ApiResource(denormalizationContext: ['groups' => ['planning:create']])]
class Planning
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('planning:create')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('planning:create')]
    private ?string $description = null;



    #[ORM\OneToMany(mappedBy: 'planning', targetEntity: Collaborator::class)]
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

    public function addCollaborators(Collaborator $collaborators): self
    {
        if (!$this->collaborators->contains($collaborators)) {
            $this->collaborators->add($collaborator);
            $collaborator->setPlanning($this);
        }

        return $this;
    }

    public function removeCollaborators(Collaborator $collaborator): self
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
