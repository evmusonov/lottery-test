<?php

namespace Casino\Infrastructure\Doctrine\Repository;

use Casino\Domain\Repository\SettingRepositoryInterface;

class SettingRepository extends AbstractDoctrineRepository implements SettingRepositoryInterface
{
    protected $entityClass = 'Casino\Domain\Entity\Setting';
}