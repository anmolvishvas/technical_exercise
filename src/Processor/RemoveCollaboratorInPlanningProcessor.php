<?php

declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Planning;
use App\Repository\PlanningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RemoveCollaboratorInPlanningProcessor implements ProcessorInterface
{
    public function __construct(private EntityManagerInterface $entityManager, private PlanningRepository $planningRepository)
    {
    }

    /** @param Planning $data */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Planning
    {
        if (!isset($uriVariables['id'])) {
            throw new BadRequestHttpException('Id is compulsory');
        }
        $planning = $this->planningRepository->find($uriVariables['id']);

        if (!$planning) {
            throw new NotFoundHttpException('Planning not found');
        }
        $collaborators = $data->getCollaborators();
        if ($collaborators->count() <= 0) {
            return $planning;
        }
        foreach ($collaborators as $collaborator) {
            $planning->removeCollaborator($collaborator);
            $collaborator->setPlanning(null);
        }
        $this->entityManager->flush();

        return $planning;
    }
}
