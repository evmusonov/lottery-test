<?php

namespace Casino\Domain\Entity;

class BonusPrize extends AbstractPrize
{
    protected $amount;

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }
}