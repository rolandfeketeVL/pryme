<?php
namespace App\Service;

use App\Entity\MembershipGroup;
use stdClass;

class MembershipGroupService
{
    public function prepareMembershipGroup(MembershipGroup $membershipGroup)
    {
        $m = new stdClass();
        $m->name = $membershipGroup->getName();
        $m->benefitLink = $membershipGroup->getBenefitLink();

        return $m;
    }
}