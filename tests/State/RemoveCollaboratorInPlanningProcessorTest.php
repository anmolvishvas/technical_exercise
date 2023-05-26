<?php

declare(strict_types=1);

namespace App\tests\State;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlanningRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\State\RemoveCollaboratorInPlanningProcessor;
use App\Entity\Planning;
use App\Entity\Collaborator;
use ApiPlatform\Metadata\Operation;

class RemoveCollaboratorInPlanningProcessorTest extends TestCase
{
    private EntityManagerInterface|MockObject $entityManager;
    private PlanningRepository|MockObject $planningRepository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->planningRepository = $this->createMock(PlanningRepository::class);
    }

    public function testProcessShouldRemoveCollaboratorsFromPlanning()
    {
        $processor = new RemoveCollaboratorInPlanningProcessor($this->entityManager, $this->planningRepository);

        $planningId = 1;
        $collaborator1 = new Collaborator();
        $collaborator2 = new Collaborator();

        $planning = new Planning();
        $planning->setId($planningId);
        $planning->addCollaborator($collaborator1);
        $planning->addCollaborator($collaborator2);

        $data = $planning;
        $operation = $this->createMock(Operation::class);
        $uriVariables = ['id' => $planningId];

        $this->planningRepository
            ->expects($this->once())
            ->method('find')
            ->with($planningId)
            ->willReturn($planning);

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $result = $processor->process($data, $operation, $uriVariables);

        $this->assertInstanceOf(Planning::class, $result);
        $this->assertEquals($planningId, $result->getId());
        $this->assertCount(0, $result->getCollaborators());
        $this->assertNull($collaborator1->getPlanning());
        $this->assertNull($collaborator2->getPlanning());
    }

    public function testProcessShouldThrowExceptionWhenIdNotProvided()
    {
        $processor = new RemoveCollaboratorInPlanningProcessor($this->entityManager, $this->planningRepository);

        $data = new Planning();
        $operation = $this->createMock(Operation::class);
        $uriVariables = [];

        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('Id is compulsory');

        $processor->process($data, $operation, $uriVariables);
    }

    public function testProcessShouldThrowExceptionWhenPlanningNotFound()
    {
        $processor = new RemoveCollaboratorInPlanningProcessor($this->entityManager, $this->planningRepository);

        $planningId = 1;

        $data = new Planning();
        $operation = $this->createMock(Operation::class);
        $uriVariables = ['id' => $planningId];

        $this->planningRepository
            ->expects($this->once())
            ->method('find')
            ->with($planningId)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Planning not found');

        $processor->process($data, $operation, $uriVariables);
    }
}
