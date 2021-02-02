<?php

namespace Casino\Domain\Factory;

use Casino\Domain\Entity\Item;
use Casino\Domain\Service\CalculateService;

class ItemFactory
{
    public function create($name, $count)
    {
        $item = new Item();
        $item->setUid(CalculateService::getHash());
        $item->setName($name);
        $item->setCount($count);

        return $item;
    }
}