<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\CollaboratorsRepository;
use App\Repository\LeaveRepository;
use Symfony\Bundle\SecurityBundle\Security;

class LeaveProvider implements ProviderInterface
{
    public function __construct(
        private readonly Security $security,
        private readonly LeaveRepository $planningRepository,
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
        $leaves = $this->planningRepository->findLeaveOfLoggedInUserPlanning($collaborator->getPlanning());

        return $leaves;
    }
}
