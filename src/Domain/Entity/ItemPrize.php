<?php

namespace Casino\Domain\Entity;

class ItemPrize extends AbstractPrize
{
    protected $itemId;

    public function getItemId()
    {
        return $this->itemId;
    }

    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
        return $this;
    }
}