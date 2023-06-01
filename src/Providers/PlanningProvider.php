<?php

declare(strict_types=1);

namespace App\Providers;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\CollaboratorsRepository;
use App\Repository\PlanningRepository;
use Symfony\Bundle\SecurityBundle\Security;

class PlanningProvider implements ProviderInterface
{
    public function __construct(
        private readonly Security $security,
        private readonly PlanningRepository $planningRepository,
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
        $planning = $this->planningRepository->findPlanningOfLoggedInUserCollaborator($collaborator);

        return $planning;
    }
}
