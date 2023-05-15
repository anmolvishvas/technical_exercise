<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CollaboratorsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollaboratorsRepository::class)]
#[ApiResource]
class Collaborators
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $familyName = null;

    #[ORM\Column(length: 255)]
    private ?string $givenName = null;

    #[ORM\Column(length: 255)]
    private ?string $jobTitle = null;

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
}
