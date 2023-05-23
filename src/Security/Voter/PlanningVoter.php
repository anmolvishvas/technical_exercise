<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Planning;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PlanningVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, ['REMOVE_PLANNING'])
        && $subject instanceof Planning;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if (!$subject instanceof Planning) {
            return false;
        }

        switch ($attribute) {
            case 'REMOVE_PLANNING':
                return $this->canRemovePlanning($subject);
        }

        return false;
    }

    private function canRemovePlanning(Planning $planning): bool
    {
        return $planning->getCollaborators()->isEmpty();
    }
}
