<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Planning;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlanningFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; ++$i) {
            $planning = new Planning();
            $planning->setName("Planning $i");
            $planning->setDescription("Description Planning $i");
            $manager->persist($planning);
            $this->addReference("PLANNING_$i", $planning);
        }

        $manager->flush();
    }
}
