<?php

namespace Application\Controller;

use Application\View\RenderInterface;
use Casino\Domain\Service\ConfirmPrizeService;
use Casino\Domain\Service\PrizeGivingService;

class PrizeController extends Controller
{
    protected $prizeGivingService;
    protected $confirmPrizeService;

    public function __construct(
        RenderInterface $render,
        PrizeGivingService $prizeGivingService,
        ConfirmPrizeService $confirmPrizeService
    ) {
        parent::__construct($render);
        $this->prizeGivingService = $prizeGivingService;
        $this->confirmPrizeService = $confirmPrizeService;
    }

    public function index()
    {
        echo $this->render::view('prize/index');
    }

    public function spin()
    {
        echo $this->render::view('prize/spin', ['prize' => $this->prizeGivingService->getRandomPrize()]);
    }

    public function accept()
    {
        if (count($_POST)) {
            $this->confirmPrizeService->accept($_POST);
        }

        header("Location: /users/profile");
        exit;
    }

    public function decline()
    {
        if (count($_POST)) {
            $this->confirmPrizeService->decline($_POST);
        }

        header("Location: /users/profile");
        exit;
    }
}