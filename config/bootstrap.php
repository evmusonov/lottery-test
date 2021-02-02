<?php
/**
 * The bootstrap file creates and returns the container.
 */

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(CONFIG_DIR . '/container.php');
$container = $containerBuilder->build();

return $container;