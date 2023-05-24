<?php

namespace App\DataFixtures;

use App\DBAL\Types\EnumLeaveReasonType;
use App\Entity\Collaborator;
use App\Entity\Leave;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LeaveFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $index = 1;
        for($i = 1; $i <=15; $i++) {
            $leave = new Leave();
            $leave->setStartDate(new DateTime('2023-05-24T10:23:31.088Z'));
            $leave->setEndDate(new DateTime('2023-05-30T10:23:31.088Z'));
            $leave->setReason(EnumLeaveReasonType::UNPAID);
            $leave->setCollaborator($this->getReference(UserFixtures::ADMIN_COLLABORATOR_REFERENCE));
            $leave->setPlanning($this->getReference("PLANNING_".$index));
            $manager->persist($leave);
            if ($index===5) {
                $index=1;
                continue;
            }
            $index++;
        }

        $old_index=1;
        for($i = 1; $i <=15; $i++) {
            $leave = new Leave();
            $leave->setStartDate(new DateTime('2023-05-24T10:23:31.088Z'));
            $leave->setEndDate(new DateTime('2023-05-30T10:23:31.088Z'));
            $leave->setReason(EnumLeaveReasonType::PAID);
            $leave->setCollaborator($this->getReference(UserFixtures::USER_COLLABORATOR_REFERENCE));
            $leave->setPlanning($this->getReference("PLANNING_".$old_index));
            $manager->persist($leave);
            if ($old_index===5) {
                $old_index=1;
                continue;
            }
            $old_index++;
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
