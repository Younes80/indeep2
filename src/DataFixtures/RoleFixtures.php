<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    const ROLES_TYPE = [ "Super Admin", "Admin", "user" ];
    
    public function load(ObjectManager $manager)
    {
        foreach(self::ROLES_TYPE as $key => $value){
            $role = new Role();
            $role->setName($value);

            $this->addReference("role_$key", $role);

            $manager->persist($role);
        }

        $manager->flush();
    }
}
