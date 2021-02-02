<?php

use Application\Controller\PrizeController;
use Application\Controller\UserController;
use Application\View\RenderInterface;
use Application\View\TwigRender;
use Casino\Domain\Factory\BonusPrizeFactory;
use Casino\Domain\Factory\CashPrizeFactory;
use Casino\Domain\Factory\ItemPrizeFactory;
use Casino\Domain\Repository\BonusPrizeRepositoryInterface;
use Casino\Domain\Repository\CashPrizeRepositoryInterface;
use Casino\Domain\Repository\ItemPrizeRepositoryInterface;
use Casino\Domain\Repository\ItemRepositoryInterface;
use Casino\Domain\Repository\SettingRepositoryInterface;
use Casino\Domain\Repository\UserRepositoryInterface;
use Casino\Domain\Service\ConfirmPrizeService;
use Casino\Domain\Service\PrizeGivingService;
use Casino\Infrastructure\Doctrine\Repository\BonusPrizeRepository;
use Casino\Infrastructure\Doctrine\Repository\CashPrizeRepository;
use Casino\Infrastructure\Doctrine\Repository\ItemPrizeRepository;
use Casino\Infrastructure\Doctrine\Repository\ItemRepository;
use Casino\Infrastructure\Doctrine\Repository\SettingRepository;
use Casino\Infrastructure\Doctrine\Repository\UserRepository;
use Casino\Service\InputFilter\UserInputFilter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

return [
    RenderInterface::class => new TwigRender(),
    'DoctrineIsDevMode' => true,
    'DoctrineProxyDir' => null,
    'DoctrineCache' => null,
    'DoctrineConfig' => function (\Psr\Container\ContainerInterface $c) {
        return Setup::createXMLMetadataConfiguration(
            [CORE_DIR . "/Infrastructure/Doctrine/Mapping"],
            $c->get('DoctrineIsDevMode'),
            $c->get('DoctrineProxyDir'),
            $c->get('DoctrineCache'),
        );
    },
    'DoctrineConnection' => function () {
        return [
            'dbname' => 'clean',
            'user' => 'root',
            'password' => 'root',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ];
    },
    'DoctrineEntityManager' => function (\Psr\Container\ContainerInterface $c) {
        return EntityManager::create($c->get('DoctrineConnection'), $c->get('DoctrineConfig'));
    },

    //
    //Interfaces
    //
    SettingRepositoryInterface::class => function (\Psr\Container\ContainerInterface $c) {
        return new SettingRepository($c->get('DoctrineEntityManager'));
    },
    UserRepositoryInterface::class => function (\Psr\Container\ContainerInterface $c) {
        return new UserRepository($c->get('DoctrineEntityManager'));
    },
    BonusPrizeRepositoryInterface::class => function (\Psr\Container\ContainerInterface $c) {
        return new BonusPrizeRepository($c->get('DoctrineEntityManager'));
    },
    CashPrizeRepositoryInterface::class => function (\Psr\Container\ContainerInterface $c) {
        return new CashPrizeRepository($c->get('DoctrineEntityManager'));
    },
    ItemPrizeRepositoryInterface::class => function (\Psr\Container\ContainerInterface $c) {
        return new ItemPrizeRepository($c->get('DoctrineEntityManager'));
    },
    ItemRepositoryInterface::class => function (\Psr\Container\ContainerInterface $c) {
        return new ItemRepository($c->get('DoctrineEntityManager'));
    },

    //
    //Services
    //
    PrizeGivingService::class => function (\Psr\Container\ContainerInterface $c) {
        return new PrizeGivingService(
            $c->get(CashPrizeFactory::class),
            $c->get(BonusPrizeFactory::class),
            $c->get(ItemPrizeFactory::class)
        );
    },
    ConfirmPrizeService::class => function (\Psr\Container\ContainerInterface $c) {
        return new ConfirmPrizeService(
            $c->get(BonusPrizeRepositoryInterface::class),
            $c->get(CashPrizeRepositoryInterface::class),
            $c->get(ItemPrizeRepositoryInterface::class),
            $c->get(UserRepositoryInterface::class),
            $c->get(ItemRepositoryInterface::class),
            $c->get(SettingRepositoryInterface::class),
        );
    },

    //
    //Factories
    //
    BonusPrizeFactory::class => function (\Psr\Container\ContainerInterface $c) {
        return new BonusPrizeFactory(
            $c->get(SettingRepositoryInterface::class),
            $c->get(BonusPrizeRepositoryInterface::class),
        );
    },
    CashPrizeFactory::class => function (\Psr\Container\ContainerInterface $c) {
        return new CashPrizeFactory(
            $c->get(SettingRepositoryInterface::class),
            $c->get(CashPrizeRepositoryInterface::class),
        );
    },
    ItemPrizeFactory::class => function (\Psr\Container\ContainerInterface $c) {
        return new ItemPrizeFactory(
            $c->get(SettingRepositoryInterface::class),
            $c->get(ItemPrizeRepositoryInterface::class),
            $c->get(ItemRepositoryInterface::class),
            new \Casino\Domain\Factory\ItemFactory()
        );
    },

    //
    //Controllers
    //
    UserController::class => function (\Psr\Container\ContainerInterface $c) {
        return new UserController(
            $c->get(RenderInterface::class),
            $c->get(UserRepositoryInterface::class),
            new UserInputFilter(),
            new \Laminas\Hydrator\ClassMethodsHydrator(),
            new \Casino\Domain\Factory\UserFactory()
        );
    },
    PrizeController::class => function (\Psr\Container\ContainerInterface $c) {
        return new PrizeController(
            $c->get(RenderInterface::class),
            $c->get(PrizeGivingService::class),
            $c->get(ConfirmPrizeService::class)
        );
    },
];