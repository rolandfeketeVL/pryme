<?php

namespace App\DataFixtures;

use App\Entity\Membership;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MembershipFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $membership = new Membership();
        $membership->setName('Private Training');
        $membership->setCredits(12);
        $membership->setMinutes(45);
        $membership->setPersonsNo(10);
        $membership->setPrice(1000);
        $membership->setValability(new \DateTime());
        $membership->addBenefit($this->getReference('benefit_1'));

        $manager->persist($membership);

        $membership2 = new Membership();
        $membership2->setName('Group Training');
        $membership2->setCredits(8);
        $membership2->setMinutes(45);
        $membership2->setPersonsNo(30);
        $membership2->setPrice(800);
        $membership2->setValability(new \DateTime());
        $membership2->addBenefit($this->getReference('benefit_1'));
        $membership2->addBenefit($this->getReference('benefit_2'));

        $manager->persist($membership2);

        $membership3 = new Membership();
        $membership3->setName('Online Training');
        $membership3->setCredits(3);
        $membership3->setMinutes(60);
        $membership3->setPersonsNo(900);
        $membership3->setPrice(500);
        $membership3->setValability(new \DateTime());
        $membership3->addBenefit($this->getReference('benefit_1'));
        $membership3->addBenefit($this->getReference('benefit_2'));
        $membership3->addBenefit($this->getReference('benefit_4'));

        $manager->persist($membership3);

        $manager->flush();
    }
}
