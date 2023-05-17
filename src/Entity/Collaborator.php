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
#[ApiResource(
    denormalizationContext: ['groups' => ['collaborator:create']],
    normalizationContext: ['groups' => ['read:Collaborator']],
)]
class Collaborator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Planning','read:Collaborator'])] 
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['collaborator:create', 'read:Planning','read:Collaborator'])] 
    private ?string $familyName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['collaborator:create', 'read:Planning','read:Collaborator'])]
    private ?string $givenName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['collaborator:create', 'read:Planning','read:Collaborator'])]
    private ?string $jobTitle = null;

    #[ORM\ManyToOne(inversedBy: 'collaborators', targetEntity: Planning::class, cascade: ['persist'])]
    #[Groups('read:Collaborator')] 
    private ?Planning $planning = null;

    #[ORM\ManyToOne(targetEntity: Leave::class, inversedBy: 'collaborators')]
    private ?Leave $leave = null;


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
}
