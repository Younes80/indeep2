<?php

namespace App\DataFixtures;

use App\Entity\Offer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OfferFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [ContractFixtures::class, ContractTypeFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        for ($i = 0; $i < 10; $i++) {
            $offer = new Offer();
            $offer
                ->setTitle($faker->jobTitle)
                ->setCompany($faker->company)
                ->setCity($faker->city)
                ->setCreatedAt($faker->dateTimeBetween('-2 months'))
                ->setDescription($faker->text(200));

            $contract = $this->getReference("contract_" . rand(0, 3));
            $offer->setContract($contract);

            $contractType = $this->getReference("contract_type_" . rand(0, 1));
            $offer->setContractType($contractType);


            $manager->persist($offer);
        }

        $manager->flush();
    }
}
