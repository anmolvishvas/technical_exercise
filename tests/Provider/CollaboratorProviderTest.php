<?php

declare(strict_types=1);

namespace App\tests\Provider;

use PHPUnit\Framework\TestCase;
use App\Provider\CollaboratorProvider;
use ApiPlatform\Metadata\Operation;
use App\Repository\CollaboratorsRepository;
use Symfony\Bundle\SecurityBundle\Security;
use PHPUnit\Framework\MockObject\MockObject;
use App\Entity\User;
use App\Entity\Collaborator;
use App\Entity\Planning;

class CollaboratorProviderTest extends TestCase
{
    private Security|MockObject $security;
    private CollaboratorsRepository|MockObject $collaboratorsRepository;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->collaboratorsRepository = $this->createMock(CollaboratorsRepository::class);
    }

    public function testProvide(): void
    {
        $provider = new CollaboratorProvider($this->security, $this->collaboratorsRepository);

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

        $this->collaboratorsRepository
            ->expects($this->once())
            ->method('findCollaboratorsOfLoggedInUserPlanning')
            ->with($planning)
            ->willReturn([]);

        $result = $provider->provide($operation, $uriVariables, $context);

        $this->assertEquals([], $result);
    }
}
