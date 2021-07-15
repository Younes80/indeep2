<?php

namespace App\DataFixtures;

use App\Entity\Contract;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContractFixtures extends Fixture
{
    const CONTRATS = ["CDI", "CDD", "FREELANCE", "ALTERNANT"];

    public function load(ObjectManager $manager)
    {
        foreach (self::CONTRATS as $key => $value) {
            $contract = new Contract();
            $contract->setName($value);

            $this->addReference("contract_$key", $contract);

            $manager->persist($contract);
        }

        $manager->flush();
    }
}
