<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LeaveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use App\DBAL\Types\EnumLeaveReasonType;


#[ORM\Entity(repositoryClass: LeaveRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:Leave']],
    denormalizationContext: ['groups' => ['write:Leave']],
)]
#[ORM\Table(name: '`leave`')]
class Leave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Leave'])] 
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['read:Leave','write:Leave'])] 
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['read:Leave','write:Leave'])] 
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: 'EnumLeaveReasonType')]
    #[DoctrineAssert\EnumType(entity: EnumLeaveReasonType::class)]
    #[Groups(['read:Leave','write:Leave'])] 
    private ?string $reason = null;

    #[ORM\ManyToOne(inversedBy: "leaves", targetEntity: Collaborator::class)]
    #[Groups(['read:Leave','write:Leave'])]
    private Collaborator $collaborator;

    #[Groups(['read:Leave'])] 
    private int $numberOfDays = 0;

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
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return Collection<int, Collaborator>
     */
    public function getCollaborator(): Collaborator
    {
        return $this->collaborator;
    }

    public function setCollaborator(Collaborator $collaborator): self
    {
        $this->collaborator = $collaborator;

        return $this;
    }

    public function getNumberOfDays(): ?int
    {
        return $this->numberOfDays;
    }

    public function setNumberOfDays(int $numberOfDays): self
    {
        $this->numberOfDays = $numberOfDays;

        return $this;
    }

}