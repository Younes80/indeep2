<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture implements DependentFixtureInterface
{


    public function getDependencies()
    {
        return [RoleFixtures::class];
    }
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager)
    {

        $faker = Factory::create("fr_FR");
        for($i=0;$i<10;$i++){
            $user = new User();
            $user
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword($this->passwordHasher->hashPassword($user, 'the_new_password'));

            $role = $this->getReference("role_" . rand(0, 2));
            $user->setRole($role);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
