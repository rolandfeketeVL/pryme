<?php
namespace App\Service;

use App\Entity\Users;
use stdClass;

class UserService
{
    public function prepareUser(Users $user)
    {
        $u = new stdClass();

        $u->first_name = $user->getFirstName();
        $u->last_name = $user->getLastName();
        $u->email = $user->getEmail();
        $u->phone = $user->getPhone();
        $u->street = $user->getStreet();
        $u->city = $user->getCity();
        $u->zip = $user->getZip();
        $u->state = $user->getState();
        $u->country = $user->getCountry();
        $u->creditsRemaining = $user->getCreditsRemaining();
        $u->membershipID = $user->getMembership()->getId();
        $u->membershipName = $user->getMembership()->getName();
        $u->membershipExpiryDate = $user->getMembershipExpiryDate();

        return $u;
    }
}