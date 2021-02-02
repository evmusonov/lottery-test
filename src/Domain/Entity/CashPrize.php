<?php

namespace Casino\Domain\Entity;

class CashPrize extends AbstractPrize
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