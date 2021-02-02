<?php

namespace Casino\Domain\Factory;

use Casino\Domain\Entity\BonusPrize;
use Casino\Domain\Repository\BonusPrizeRepositoryInterface;
use Casino\Domain\Repository\SettingRepositoryInterface;
use Casino\Domain\Service\CalculateService;

class BonusPrizeFactory implements PrizeFactoryInterface
{
    protected $settingRepository;
    protected $bonusPrizeRepository;

    public function __construct(
        SettingRepositoryInterface $settingRepository,
        BonusPrizeRepositoryInterface $prizeRepository
    ) {
        $this->settingRepository = $settingRepository;
        $this->bonusPrizeRepository = $prizeRepository;
    }

    public function create() : array
    {
        $bonus = $this->getBonusAmount();
        $bonusPrize = new BonusPrize();
        $bonusPrize->setUid(CalculateService::getHash());
        $bonusPrize->setAmount($bonus);
        $bonusPrize->setIsAccepted(0);
        $bonusPrize->setUserId($_SESSION['user']['id']);
        $this->bonusPrizeRepository->begin()->persist($bonusPrize)->commit();


        return [
            'uid'    => $bonusPrize->getUid(),
            'title' => 'Bonus',
            'value' => $bonus,
            'type'  => get_class($bonusPrize)
        ];
    }

    protected function getBonusAmount()
    {
        $limitFrom = $this->settingRepository->getOneBy([
            'key' => 'bonus_from'
        ]);
        $limitTo = $this->settingRepository->getOneBy([
            'key' => 'bonus_to'
        ]);

        return rand($limitFrom->getValue(), $limitTo->getValue());
    }
}