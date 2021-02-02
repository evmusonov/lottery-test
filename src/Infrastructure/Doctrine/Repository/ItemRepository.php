<?php

namespace Casino\Infrastructure\Doctrine\Repository;

use Casino\Domain\Repository\ItemRepositoryInterface;

class ItemRepository extends AbstractDoctrineRepository implements ItemRepositoryInterface
{
    protected $entityClass = 'Casino\Domain\Entity\Item';
}