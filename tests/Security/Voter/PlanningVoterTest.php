<?php

namespace App\Tests\Security\Voter;

use App\Entity\Collaborator;
use App\Entity\Planning;
use App\Security\Voter\PlanningVoter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class PlanningVoterTest extends TestCase
{
    private TokenInterface|MockObject $token;

    private Planning $planning;

    private PlanningVoter $planningVoter;

    protected function setUp(): void
    {
        $this->token = $this->createMock(TokenInterface::class);
        $this->planning = new Planning();
        $this->planningVoter = new PlanningVoter();
    }

    public function testAbstainCauseDoesNotSupportAttribute(): void
    {
        $this->assertEquals(
            VoterInterface::ACCESS_ABSTAIN,
            $this->planningVoter->vote(
                $this->token,
                $this->planning,
                ['invalid'],
            ),
        );
    }

    public function testCanRemovePlanning(): void
    {
        $this->planning->setId(5);
        $this->planning->setName('Presentation');
        $this->planning->setDescription('Description Planning 5');
        $this->assertEquals(
            VoterInterface::ACCESS_GRANTED,
            $this->planningVoter->vote(
                $this->token,
                $this->planning,
                ['REMOVE_PLANNING'],
            ),
        );
    }

    public function testCannotRemovePlanning(): void
    {
        $this->planning->setId(2);
        $this->planning->setName('Planning 2');
        $this->planning->setDescription('Description Planning 2');
        $this->planning->addCollaborator(new Collaborator());
        $this->assertEquals(
            VoterInterface::ACCESS_DENIED,
            $this->planningVoter->vote(
                $this->token,
                $this->planning,
                ['REMOVE_PLANNING'],
            ),
        );
    }
}
