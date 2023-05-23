<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Collaborator;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CollaboratorStateProcessor implements ProcessorInterface
{
    private $passwordEncoder;

    public function __construct(private EntityManagerInterface $entityManager, private UserRepository $userRepository, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        if (!$data instanceof Collaborator) {
            return;
        }

        $user = new User();
        $user->setUsername(sprintf('%s_%s', time(), $data->getGivenName()));
        $user->setPassword($this->passwordEncoder->hashPassword($user, $data->getGivenName()));
        $user->setRoles(['ROLE_USER']);

        $data->setUser($user);
        $this->entityManager->persist($data);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
