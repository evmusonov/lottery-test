<?php

namespace Casino\Domain\Repository;

use Casino\Domain\Entity\AbstractEntity;
use Doctrine\ORM\QueryBuilder;

interface RepositoryInterface
{
    public function getById($id);
    public function getBy(
        $conditions = [],
        $order = [],
        $limit = null,
        $offset = null
    );
    public function getOneBy(
        $conditions = [],
        $order = []
    );
    public function getAll();
    public function builder() : QueryBuilder;
    public function persist(AbstractEntity $entity);
    public function begin();
    public function commit();
}