<?php

declare(strict_types=1);

use Framework\Exceptions\ErrorHandler;

spl_autoload_register(function (string $className) {
    $className = str_replace('\\', '/', $className);
    require "src/$className.php";
});

// set_error_handler('Framework\Exceptions\ErrorHandler::handleError');
set_error_handler([ErrorHandler::class, 'handleError']);
set_exception_handler([ErrorHandler::class, 'handleException']);

use App\Database;
use Framework\Container;


$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);
if ($path === false) {
    throw new \UnexpectedValueException("Mailformed URL: {$_SERVER['REQUEST_URI']}");
}

$router = require 'config/routes.php';
// print_r(compact('params'));

$container = new Container();
$container->set(Database::class, fn() => new Database('localhost', 'product_db', 'root', ''));
$dispatcher = new \Framework\Dispatcher($router,  $container);
$dispatcher->handle($path);
