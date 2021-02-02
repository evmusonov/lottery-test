<?php

namespace Casino\Domain\Service;

use Casino\Domain\Factory\BonusPrizeFactory;
use Casino\Domain\Factory\CashPrizeFactory;
use Casino\Domain\Factory\ItemPrizeFactory;

class PrizeGivingService
{
    protected $prizes;

    public function __construct(
        CashPrizeFactory $cashPrizeFactory,
        BonusPrizeFactory $bonusPrizeFactory,
        ItemPrizeFactory $itemPrizeFactory
    ) {
        $this->prizes = [
            $cashPrizeFactory,
            $bonusPrizeFactory,
            $itemPrizeFactory
        ];
    }

    public function getRandomPrize()
    {
        $randomKey = rand(0, count($this->prizes) - 1);
        return $this->prizes[$randomKey]->create();
    }
}