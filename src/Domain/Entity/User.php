<?php

namespace Casino\Domain\Entity;

class User extends AbstractEntity
{
    protected $email;
    protected $password;
    protected $bonus;
    protected $cash;
    protected $items;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        return $this;
    }

    public function getBonus()
    {
        return $this->bonus;
    }

    public function setBonus($bonus)
    {
        $this->bonus = $bonus;
        return $this;
    }

    public function getCash()
    {
        return $this->cash;
    }

    public function setCash($cash)
    {
        $this->cash = $cash;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }
}