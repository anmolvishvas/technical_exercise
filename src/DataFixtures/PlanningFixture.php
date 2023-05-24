<?php

namespace App\DataFixtures;

use App\DBAL\Types\EnumLeaveReasonType;
use App\Entity\Planning;
use App\Entity\Leave;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PlanningFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <=5; $i++) {
            $planning = new Planning();
            $planning->setName("Planning $i");
            $planning->setDescription("Description Planning $i");
            $manager->persist($planning);
            $this->addReference("PLANNING_$i", $planning);
        }

        $manager->flush();

    }
}
