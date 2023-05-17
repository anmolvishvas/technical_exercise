<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\LeaveReason;
use App\Repository\LeaveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeaveRepository::class)]
#[ApiResource()]
#[ORM\Table(name: '`leave`')]
class Leave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: Types::STRING)]
    private ?string $reason = null;

    #[ORM\OneToMany(mappedBy: "leave", targetEntity: Collaborator::class)]
    private Collection $collaborators;

    public function __construct()
    {
        $this->collaborators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        if (!in_array($reason, [
            LeaveReason::PAID,
            LeaveReason::UNPAID,
            LeaveReason::EXCEPTIONAL,
            LeaveReason::SENIORITY,
        ])) {
            throw new \InvalidArgumentException('Invalid leave reason.');
        }

        $this->reason = $reason;

        return $this;
    }

    /**
     * @return Collection<int, Collaborator>
     */
    public function getCollaborators(): Collection
    {
        return $this->collaborators;
    }
}
