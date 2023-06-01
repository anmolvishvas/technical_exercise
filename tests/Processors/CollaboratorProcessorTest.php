<?php

declare(strict_types=1);

namespace App\tests\Processors;

use ApiPlatform\Metadata\Post;
use App\Entity\Collaborator;
use App\Entity\Planning;
use App\Repository\UserRepository;
use App\Processors\CollaboratorProcessor;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CollaboratorProcessorTest extends TestCase
{
    private EntityManagerInterface|MockObject $entityManager;
    private UserRepository|MockObject $userRepository;
    private UserPasswordHasherInterface|MockObject $passwordEncoder;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->passwordEncoder = $this->createMock(UserPasswordHasherInterface::class);
    }

    public function testProcess(): void
    {
        $this->passwordEncoder
            ->expects(self::once())
            ->method('hashPassword');

        $this->entityManager
            ->expects(self::exactly(2))
            ->method('persist');

        $this->entityManager
            ->expects(self::once())
            ->method('flush');
        
        $collaboratorProcessor = new CollaboratorProcessor(
            $this->entityManager,
            $this->userRepository,
            $this->passwordEncoder
        );

        $expected = (new Collaborator())
            ->setFamilyName('NewCollaborator')
            ->setGivenName('NewGivenName')
            ->setJobTitle('NewJob');
            
        $operation = new Post('/fake', class: Collaborator::class);

        $collaboratorProcessor->process(
            $expected,
            $operation,
            []
        );
    }

    public function testProcessFailed(): void
    {
        $this->passwordEncoder
            ->expects(self::never())
            ->method('hashPassword');

        $this->entityManager
            ->expects(self::never())
            ->method('persist');

        $this->entityManager
            ->expects(self::never())
            ->method('flush');
        
        $collaboratorProcessor = new CollaboratorProcessor(
            $this->entityManager,
            $this->userRepository,
            $this->passwordEncoder
        );

        $operation = new Post('/fake', class: Collaborator::class);

        $collaboratorProcessor->process(
            new Planning(),
            $operation,
            []
        );
    }
}
