<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\DBAL\Types\EnumLeaveReasonType;
use App\Repository\LeaveRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LeaveRepository::class)]
#[ApiResource(
    security: 'is_granted(\'ROLE_USER\')',
    openapiContext: [
        'security' => [['bearerAuth' => []]],
    ],
    normalizationContext: ['groups' => ['read:Leave']],
    denormalizationContext: ['groups' => ['write:Leave']],
    operations: [
        new GetCollection(
            uriTemplate: '/leaves/my_leaves',
        ),
        new Post(),
    ],
)]
#[ORM\Table(name: '`leave`')]
class Leave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:Leave', 'user_leave', 'read:Planning'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['read:Leave', 'write:Leave', 'user_leave', 'read:Planning'])]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['read:Leave', 'write:Leave', 'user_leave', 'read:Planning'])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: 'EnumLeaveReasonType')]
    #[DoctrineAssert\EnumType(entity: EnumLeaveReasonType::class)]
    #[Groups(['read:Leave', 'write:Leave', 'user_leave', 'read:Planning'])]
    private ?string $reason = null;

    #[ORM\ManyToOne(inversedBy: 'leaves', targetEntity: Collaborator::class)]
    #[Groups(['read:Leave', 'write:Leave', 'user_leave'])]
    private Collaborator $collaborator;

    #[Groups(['read:Leave', 'user_leave', 'read:Planning'])]
    private int $numberOfDays = 0;

    #[ORM\ManyToOne(inversedBy: 'leaves')]
    #[Groups(['read:Leave', 'write:Leave'])]
    private ?Planning $planning = null;

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
