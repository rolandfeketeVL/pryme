<?php
namespace App\Service;

use App\Entity\Membership;
use stdClass;

class MembershipService
{
    public function prepareMembership(Membership $membership)
    {
        $m = new stdClass();
        $m->name = $membership->getName();
        $m->credits = $membership->getCredits();
        $m->price = $membership->getPrice();
        $m->persons_no = $membership->getPersonsNo();
        $m->minutes = $membership->getMinutes();
        $m->valability = $membership->getValability();

        return $m;
    }
}