<?php

declare(strict_types=1);

use Framework\Dotenv;
use Framework\Exceptions\ErrorHandler;

define('ROOT_PATH', dirname(__DIR__));

spl_autoload_register(function (string $className) {
    $className = str_replace('\\', '/', $className);
    require ROOT_PATH . "/src/$className.php";
});

set_error_handler([ErrorHandler::class, 'handleError']);
set_exception_handler([ErrorHandler::class, 'handleException']);

$env = new Dotenv();
$env->load(ROOT_PATH . '/.env');

$router = require ROOT_PATH . '/config/routes.php';
$container = require ROOT_PATH . "/config/services.php";
$dispatcher = new \Framework\Dispatcher($router,  $container);
$request = new \Framework\Request($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
$dispatcher->handle($request);
