<?php

declare(strict_types=1);

namespace App\tests\Providers;

use PHPUnit\Framework\TestCase;
use App\Providers\PlanningProvider;
use ApiPlatform\Metadata\Operation;
use App\Repository\CollaboratorsRepository;
use App\Repository\PlanningRepository;
use Symfony\Bundle\SecurityBundle\Security;
use PHPUnit\Framework\MockObject\MockObject;
use App\Entity\User;
use App\Entity\Collaborator;
use App\Entity\Planning;

class PlanningProviderTest extends TestCase
{
    private Security|MockObject $security;
    private CollaboratorsRepository|MockObject $collaboratorsRepository;
    private PlanningRepository|MockObject $planningRepository;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->planningRepository = $this->createMock(PlanningRepository::class);
        $this->collaboratorsRepository = $this->createMock(CollaboratorsRepository::class);
    }

    public function testProvide(): void
    {
        $provider = new PlanningProvider($this->security, $this->planningRepository, $this->collaboratorsRepository);

        $user = new User();
        $collaborator = new Collaborator();
        $planning = new Planning();
        $collaborator->setUser($user);
        
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

        $this->planningRepository
            ->expects($this->once())
            ->method('findPlanningOfLoggedInUserCollaborator')
            ->with($collaborator)
            ->willReturn([]);

        $result = $provider->provide($operation, $uriVariables, $context);

        $this->assertEquals([], $result);
    }
}
