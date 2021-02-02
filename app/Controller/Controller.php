<?php

namespace Application\Controller;

use Application\View\RenderInterface;

abstract class Controller
{
    protected $render;

    public function __construct(RenderInterface $render)
    {
        $this->render = $render;
    }
}