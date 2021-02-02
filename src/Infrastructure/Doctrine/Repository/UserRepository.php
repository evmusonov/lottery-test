<?php

namespace Casino\Infrastructure\Doctrine\Repository;

use Casino\Domain\Repository\UserRepositoryInterface;

class UserRepository extends AbstractDoctrineRepository implements UserRepositoryInterface
{
    protected $entityClass = 'Casino\Domain\Entity\User';
}