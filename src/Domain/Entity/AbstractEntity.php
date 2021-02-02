<?php

namespace Casino\Domain\Entity;

abstract class AbstractEntity
{
    protected $id;
    protected $uid;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = md5($uid);
        return $this;
    }
}