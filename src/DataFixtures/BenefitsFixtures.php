<?php

namespace App\DataFixtures;

use App\Entity\Benefits;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BenefitsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $benefits = new Benefits();
        $benefits->setName('Workshop 1');
        $manager->persist($benefits);

        $benefits2 = new Benefits();
        $benefits2->setName('Workshop 2');
        $manager->persist($benefits2);

        $benefits3 = new Benefits();
        $benefits3->setName('Workshop 3');
        $manager->persist($benefits3);

        $benefits4 = new Benefits();
        $benefits4->setName('Workshop 4');
        $manager->persist($benefits4);

        $manager->flush();

        $this->addReference('benefit_1', $benefits);
        $this->addReference('benefit_2', $benefits2);
        $this->addReference('benefit_3', $benefits3);
        $this->addReference('benefit_4', $benefits4);
    }
}
