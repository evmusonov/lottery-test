<?php

namespace Casino\Domain\Service;

use Casino\Domain\Entity\BonusPrize;
use Casino\Domain\Entity\CashPrize;
use Casino\Domain\Entity\ItemPrize;
use Casino\Domain\Repository\BonusPrizeRepositoryInterface;
use Casino\Domain\Repository\CashPrizeRepositoryInterface;
use Casino\Domain\Repository\ItemPrizeRepositoryInterface;
use Casino\Domain\Repository\ItemRepositoryInterface;
use Casino\Domain\Repository\SettingRepositoryInterface;
use Casino\Domain\Repository\UserRepositoryInterface;

class ConfirmPrizeService
{
    protected $bonusPrizeRepository;
    protected $cashPrizeRepository;
    protected $itemPrizeRepository;
    protected $userRepository;
    protected $itemRepository;
    protected $settingRepository;

    public function __construct(
        BonusPrizeRepositoryInterface $bonusPrizeRepository,
        CashPrizeRepositoryInterface $cashPrizeRepository,
        ItemPrizeRepositoryInterface $itemPrizeRepository,
        UserRepositoryInterface $userRepository,
        ItemRepositoryInterface $itemRepository,
        SettingRepositoryInterface $settingRepository
    ) {
        $this->bonusPrizeRepository = $bonusPrizeRepository;
        $this->cashPrizeRepository = $cashPrizeRepository;
        $this->itemPrizeRepository = $itemPrizeRepository;
        $this->userRepository = $userRepository;
        $this->itemRepository = $itemRepository;
        $this->settingRepository = $settingRepository;
    }

    public function accept($data)
    {
        $user = $this->userRepository->getById($_SESSION['user']['id']);
        switch ($data['type']) {
            case BonusPrize::class:
                $bonus = $this->bonusPrizeRepository->getOneBy([
                    'uid' => $data['uid'],
                    'isAccepted' => 0
                ]);
                $bonus->setIsAccepted(1);

                $user->setBonus($user->getBonus() + $bonus->getAmount());

                $this->userRepository->begin()->persist($user)->commit();
                $this->bonusPrizeRepository->begin()->persist($bonus)->commit();
                break;
            case CashPrize::class:
                $cash = $this->cashPrizeRepository->getOneBy([
                    'uid' => $data['uid'],
                    'isAccepted' => 0
                ]);
                $cash->setIsAccepted(1);

                $allCash = $this->settingRepository->getOneBy([
                    'key' => 'cash'
                ]);
                $allCash->setValue($allCash->getValue() - $cash->getAmount());

                $user->setCash($user->getCash() + $cash->getAmount());

                $this->userRepository->begin()->persist($user)->commit();
                $this->settingRepository->begin()->persist($allCash)->commit();
                $this->cashPrizeRepository->begin()->persist($cash)->commit();
                break;
            case ItemPrize::class:
                $itemPrize = $this->itemPrizeRepository->getOneBy([
                    'uid' => $data['uid'],
                    'isAccepted' => 0
                ]);
                $itemPrize->setIsAccepted(1);

                $item = $itemPrize->getItemId();
                $item->setCount($item->getCount() - 1);

                $userItems = $user->getItems();
                $userItems[] = $item;
                $user->setItems($userItems);

                $this->itemPrizeRepository->begin()->persist($itemPrize)->commit();
                $this->itemRepository->begin()->persist($item)->commit();
                $this->userRepository->begin()->persist($user)->commit();
                break;
        }
    }

    public function decline($data)
    {
        switch ($data['type']) {
            case BonusPrize::class:
                $bonus = $this->bonusPrizeRepository->getOneBy([
                    'uid' => $data['uid'],
                    'isAccepted' => 0
                ]);
                $bonus->setIsAccepted(1);
                $this->bonusPrizeRepository->begin()->persist($bonus)->commit();
                break;
            case CashPrize::class:
                $cash = $this->cashPrizeRepository->getOneBy([
                    'uid' => $data['uid'],
                    'isAccepted' => 0
                ]);
                $cash->setIsAccepted(1);
                $this->cashPrizeRepository->begin()->persist($cash)->commit();
                break;
            case ItemPrize::class:
                $itemPrize = $this->itemPrizeRepository->getOneBy([
                    'uid' => $data['uid'],
                    'isAccepted' => 0
                ]);
                $itemPrize->setIsAccepted(1);
                $this->itemPrizeRepository->begin()->persist($itemPrize)->commit();
                break;
        }
    }
}