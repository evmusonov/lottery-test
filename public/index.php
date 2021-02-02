<?php

use Application\Http\Router;

session_start();

define('APP_DIR', str_replace('/public', '/app', $_SERVER['DOCUMENT_ROOT']));
define('CORE_DIR', str_replace('/public', '/src', $_SERVER['DOCUMENT_ROOT']));
define('CONFIG_DIR', str_replace('/public', '/config', $_SERVER['DOCUMENT_ROOT']));

require_once '../vendor/autoload.php';
//require_once 'autoload.php';

$container = require_once CONFIG_DIR . '/bootstrap.php';
$router = new Router($container);
$router->run();
