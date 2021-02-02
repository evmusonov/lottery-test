<?php

namespace Casino\Domain\Factory;

use Casino\Domain\Entity\CashPrize;
use Casino\Domain\Repository\CashPrizeRepositoryInterface;
use Casino\Domain\Repository\SettingRepositoryInterface;
use Casino\Domain\Service\CalculateService;

class CashPrizeFactory implements PrizeFactoryInterface
{
    protected $settingRepository;
    protected $cashPrizeRepository;

    public function __construct(
        SettingRepositoryInterface $settingRepository,
        CashPrizeRepositoryInterface $prizeRepository
    ) {
        $this->settingRepository = $settingRepository;
        $this->cashPrizeRepository = $prizeRepository;
    }

    public function create() : array
    {
        $cash = $this->getCashAmount();
        $cashPrize = new CashPrize();
        $cashPrize->setUid(CalculateService::getHash());
        $cashPrize->setAmount($cash);
        $cashPrize->setIsAccepted(0);
        $cashPrize->setUserId($_SESSION['user']['id']);
        $this->cashPrizeRepository->begin()->persist($cashPrize)->commit();


        return [
            'uid'    => $cashPrize->getUid(),
            'title' => 'Cash',
            'value' => $cash,
            'type'  => get_class($cashPrize)
        ];
    }

    protected function getCashAmount()
    {
        $limitFrom = $this->settingRepository->getOneBy([
            'key' => 'cash_from'
        ]);
        $limitTo = $this->settingRepository->getOneBy([
            'key' => 'cash_to'
        ]);
        $cashLimit = $this->settingRepository->getOneBy([
            'key' => 'cash'
        ]);

        $randomCash = rand($limitFrom->getValue(), $limitTo->getValue());

        if ($randomCash > $cashLimit->getValue()) {
            $randomCash = $cashLimit;
        }

        return $randomCash;
    }
}