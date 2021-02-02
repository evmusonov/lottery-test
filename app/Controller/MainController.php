<?php

namespace Application\Controller;

class MainController extends Controller
{
    public function index()
    {
        echo $this->render::view('main/index');
    }
}