<?php

namespace Casino\Domain\Factory;

use Casino\Domain\Entity\Item;
use Casino\Domain\Entity\ItemPrize;
use Casino\Domain\Repository\ItemPrizeRepositoryInterface;
use Casino\Domain\Repository\ItemRepositoryInterface;
use Casino\Domain\Repository\SettingRepositoryInterface;
use Casino\Domain\Service\CalculateService;

class ItemPrizeFactory implements PrizeFactoryInterface
{
    protected $settingRepository;
    protected $itemPrizeRepository;
    protected $itemRepository;
    protected $itemFactory;

    public function __construct(
        SettingRepositoryInterface $settingRepository,
        ItemPrizeRepositoryInterface $prizeRepository,
        ItemRepositoryInterface $itemRepository,
        ItemFactory $itemFactory
    ) {
        $this->settingRepository = $settingRepository;
        $this->itemPrizeRepository = $prizeRepository;
        $this->itemRepository = $itemRepository;
        $this->itemFactory = $itemFactory;
    }

    public function create() : array
    {
        $item = $this->getRandomItem();
        $itemPrize = new ItemPrize();
        $itemPrize->setUid(CalculateService::getHash());
        $itemPrize->setItemId($item);
        $itemPrize->setIsAccepted(0);
        $itemPrize->setUserId($_SESSION['user']['id']);

        $this->itemPrizeRepository->begin()->persist($itemPrize)->commit();

        return [
            'uid'    => $itemPrize->getUid(),
            'title' => 'Item',
            'value' => $item->getName(),
            'type'  => get_class($itemPrize)
        ];
    }

    protected function getRandomItem()
    {
        $qb = $this->itemRepository->builder();
        $query = $qb->select('i.id')->from(Item::class, 'i')
            ->where('i.count > 0')->getQuery();

        $items = $query->getResult();
        $rand = rand(0, count($items) - 1);

        return $this->itemRepository->getById($items[$rand]['id']);
    }
}