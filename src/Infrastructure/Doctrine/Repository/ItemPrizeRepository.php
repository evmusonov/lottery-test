<?php

namespace Casino\Infrastructure\Doctrine\Repository;

use Casino\Domain\Repository\ItemPrizeRepositoryInterface;

class ItemPrizeRepository extends AbstractDoctrineRepository implements ItemPrizeRepositoryInterface
{
    protected $entityClass = 'Casino\Domain\Entity\ItemPrize';
}