<?php

declare(strict_types=1);

namespace App\Providers;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\CollaboratorsRepository;
use Symfony\Bundle\SecurityBundle\Security;

class CollaboratorProvider implements ProviderInterface
{
    public function __construct(
        private readonly Security $security,
        private readonly CollaboratorsRepository $collaboratorsRepository,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $user = $this->security->getUser();
        $collaborator = $this->collaboratorsRepository->findOneBy(
            [
                'user' => $user
            ],
        );
        $collaboratorsPlanning = $this->collaboratorsRepository->findCollaboratorsOfLoggedInUserPlanning($collaborator->getPlanning());

        return $collaboratorsPlanning;
    }
}
