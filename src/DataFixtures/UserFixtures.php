<?php

namespace App\DataFixtures;

use App\Entity\Collaborator;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const ADMIN_USER_REFERENCE = 'admin_user';
    public const ADMIN_COLLABORATOR_REFERENCE = 'admin_collaborator';
    public const USER_REFERENCE = 'user';
    public const USER_COLLABORATOR_REFERENCE = 'user_collaborator';

    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager): void
    {
        $admin_user = new User();
        $admin_user->setUsername('1684483706_Anmol');
        $admin_user->setPassword($this->passwordEncoder->hashPassword($admin_user, 'Anmol'));
        $admin_user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin_user);
        $this->addReference(self::ADMIN_USER_REFERENCE, $admin_user);

        $admin_collaborator = new Collaborator();
        $admin_collaborator->setFamilyName('Vishvas');
        $admin_collaborator->setGivenName('Anmol');
        $admin_collaborator->setJobTitle('Junior Software Engineer');
        $admin_collaborator->setUser($admin_user);
        $admin_collaborator->setPlanning($this->getReference("PLANNING_1"));
        $manager->persist($admin_collaborator);
        $this->addReference(self::ADMIN_COLLABORATOR_REFERENCE, $admin_collaborator);


        $user = new User();
        $user->setUsername('1684489109_Vishvas');
        $user->setPassword($this->passwordEncoder->hashPassword($user, 'Vishvas'));
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);
        $this->addReference(self::USER_REFERENCE, $user);

        $user_collaborator = new Collaborator();
        $user_collaborator->setFamilyName('Santilal');
        $user_collaborator->setGivenName('Vishvas');
        $user_collaborator->setJobTitle('Shopkeeper');
        $user_collaborator->setUser($user);
        $user_collaborator->setPlanning($this->getReference("PLANNING_2"));
        $manager->persist($user_collaborator);
        $this->addReference(self::USER_COLLABORATOR_REFERENCE, $user_collaborator);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PlanningFixture::class,
        ];
    }
}
