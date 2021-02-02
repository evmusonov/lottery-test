<?php

namespace Casino\Infrastructure\Doctrine\Repository;

use Casino\Domain\Repository\BonusPrizeRepositoryInterface;

class BonusPrizeRepository extends AbstractDoctrineRepository implements BonusPrizeRepositoryInterface
{
    protected $entityClass = 'Casino\Domain\Entity\BonusPrize';
}