<?php

namespace Casino\Infrastructure\Doctrine\Repository;

use Casino\Domain\Repository\CashPrizeRepositoryInterface;

class CashPrizeRepository extends AbstractDoctrineRepository implements CashPrizeRepositoryInterface
{
    protected $entityClass = 'Casino\Domain\Entity\CashPrize';
}