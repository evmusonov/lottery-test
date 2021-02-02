<?php

namespace Casino\Domain\Service;

use Casino\Domain\Factory\BonusPrizeFactory;
use Casino\Domain\Factory\CashPrizeFactory;
use Casino\Domain\Factory\ItemPrizeFactory;

class CalculateService
{
    public static function getHash()
    {
        $all = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $count = strlen($all) - 1;
        $char = $all[rand(0, $count)];
        $salt = time();

        return $char . md5(rand(0, 100000) . $salt);
    }
}