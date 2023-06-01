<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\DBAL\Types\EnumLeaveReasonType;
use App\Entity\Leave;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LeaveFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $index = 1;
        for ($i = 1; $i <= 15; ++$i) {
            $leave = new Leave();
            $leave->setStartDate(new \DateTime('2023-05-24 10:23:31'));
            $leave->setEndDate(new \DateTime('2023-05-30 10:23:31.08'));
            $leave->setReason(EnumLeaveReasonType::UNPAID);
            $leave->setCollaborator($this->getReference(UserFixtures::ADMIN_COLLABORATOR_REFERENCE));
            $leave->setPlanning($this->getReference('PLANNING_'.$index));
            $manager->persist($leave);
            if ($index % 5 == 0) {
                continue;
            }
            ++$index;
        }

        $old_index = 1;
        for ($i = 1; $i <= 15; ++$i) {
            $leave = new Leave();
            $leave->setStartDate(new \DateTime('2023-05-24 10:23:31'));
            $leave->setEndDate(new \DateTime('2023-05-30 10:23:31.08'));
            $leave->setReason(EnumLeaveReasonType::PAID);
            $leave->setCollaborator($this->getReference(UserFixtures::USER_COLLABORATOR_REFERENCE));
            $leave->setPlanning($this->getReference('PLANNING_'.$old_index));
            $manager->persist($leave);
            if ($old_index % 5 == 0) {
                continue;
            }
            ++$old_index;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            PlanningFixture::class
        ];
    }
}
