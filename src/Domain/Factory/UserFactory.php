<?php

namespace Casino\Domain\Factory;

use Casino\Domain\Entity\User;
use Casino\Domain\Service\CalculateService;

class UserFactory
{
    public function create($bonus = 0, $cash = 0)
    {
        $user = new User();
        $user->setUid(CalculateService::getHash());
        $user->setBonus($bonus);
        $user->setCash($cash);

        return $user;
    }
}