<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CollaboratorsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CollaboratorsRepository::class)]
#[ApiResource(denormalizationContext: ['groups' => ['collaborator:create']])]
class Collaborator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('collaborator:create')]
    private ?string $familyName = null;

    #[ORM\Column(length: 255)]
    #[Groups('collaborator:create')]
    private ?string $givenName = null;

    #[ORM\Column(length: 255)]
    #[Groups('collaborator:create')]
    private ?string $jobTitle = null;

    #[ORM\ManyToOne(inversedBy: 'collaborators', targetEntity: Planning::class, cascade: ['persist'])]
    private ?Planning $planning = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getfamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setfamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getgivenName(): ?string
    {
        return $this->givenName;
    }

    public function setgivenName(string $givenName): self
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getjobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setjobTitle(string $jobTitle): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getPlanning(): ?Planning
    {
        return $this->planning;
    }

    public function setPlaning(?Planning $planning): self
    {
        $this->planning = $planning;

        return $this;
    }
}
