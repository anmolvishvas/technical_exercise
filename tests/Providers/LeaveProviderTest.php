<?php

declare(strict_types=1);

namespace App\tests\Providers;

use PHPUnit\Framework\TestCase;
use App\Providers\LeaveProvider;
use ApiPlatform\Metadata\Operation;
use App\Repository\CollaboratorsRepository;
use App\Repository\LeaveRepository;
use Symfony\Bundle\SecurityBundle\Security;
use PHPUnit\Framework\MockObject\MockObject;
use App\Entity\User;
use App\Entity\Collaborator;
use App\Entity\Planning;

class LeaveProviderTest extends TestCase
{
    private Security|MockObject $security;
    private CollaboratorsRepository|MockObject $collaboratorsRepository;
    private LeaveRepository|MockObject $leaveRepository;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->leaveRepository = $this->createMock(LeaveRepository::class);
        $this->collaboratorsRepository = $this->createMock(CollaboratorsRepository::class);
    }

    public function testProvide(): void
    {
        $provider = new LeaveProvider($this->security, $this->leaveRepository, $this->collaboratorsRepository);

        $user = new User();
        $planning = new Planning();
        $collaborator = new Collaborator();
        $collaborator->setUser($user);
        $collaborator->setPlanning($planning);
        
        $operation = $this->createMock(Operation::class);
        $uriVariables = [];
        $context = [];

        $this->security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $this->collaboratorsRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['user' => $user])
            ->willReturn($collaborator);

        $this->leaveRepository->expects($this->once())
            ->method('findLeavesOfLoggedInUserPlanning')
            ->with($planning)
            ->willReturn([]);

        $result = $provider->provide($operation, $uriVariables, $context);

        $this->assertEquals([], $result);
    }
}
