<?php

namespace Casino\Domain\Entity;

abstract class AbstractPrize extends AbstractEntity
{
    protected $userId;
    protected $isAccepted;

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getIsAccepted()
    {
        return $this->isAccepted;
    }

    public function setIsAccepted($isAccepted)
    {
        $this->isAccepted = $isAccepted;
        return $this;
    }
}