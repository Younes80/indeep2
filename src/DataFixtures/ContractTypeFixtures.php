<?php

namespace App\DataFixtures;

use App\Entity\ContractType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContractTypeFixtures extends Fixture
{
    const CONTRATS_TYPE = [ "Temps plein", "Temps partiel" ];
    
    public function load(ObjectManager $manager)
    {
        foreach(self::CONTRATS_TYPE as $key => $value){
            $contractType = new ContractType();
            $contractType->setName($value);

            $this->addReference("contract_type_$key", $contractType);

            $manager->persist($contractType);
        }

        $manager->flush();
    }
}
