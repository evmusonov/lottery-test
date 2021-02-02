<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;

define('CORE_DIR', str_replace('\config', '\src', __DIR__));

// replace with file to your own project bootstrap
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createXMLMetadataConfiguration([CORE_DIR . "/Infrastructure/Doctrine/Mapping"], $isDevMode, $proxyDir, $cache);

//$config = new \Doctrine\ORM\Configuration();
//$driver = new \Doctrine\ORM\Mapping\Driver\XmlDriver([CORE_DIR . "/Infrastructure/Doctrine/Mapping"]);
//$config->setMetadataDriverImpl($driver);

//$namespaces = [
//    CORE_DIR . '/Infrastructure/Doctrine/Mapping' => 'Casino\Domain\Entity',
//];
//$driver = new \Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver($namespaces);
//$config = new \Doctrine\ORM\Configuration();
//$config->setMetadataDriverImpl($driver);

$conn = array(
    'dbname' => 'clean',
    'user' => 'root',
    'password' => 'root',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

return ConsoleRunner::createHelperSet($entityManager);
