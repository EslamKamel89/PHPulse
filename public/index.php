<?php

declare(strict_types=1);

use Framework\Dotenv;
use Framework\Exceptions\ErrorHandler;


spl_autoload_register(function (string $className) {
    $className = str_replace('\\', '/', $className);
    require "src/$className.php";
});

set_error_handler([ErrorHandler::class, 'handleError']);
set_exception_handler([ErrorHandler::class, 'handleException']);

$env = new Dotenv();
$env->load('.env');

$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);
if ($path === false) {
    throw new \UnexpectedValueException("Mailformed URL: {$_SERVER['REQUEST_URI']}");
}

$router = require 'config/routes.php';
$container = require "config/services.php";
$dispatcher = new \Framework\Dispatcher($router,  $container);
$dispatcher->handle($path);
