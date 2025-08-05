<?php

declare(strict_types=1);
set_error_handler(function (
    int $errno,
    string $errstr,
    string $errfile,
    int $errline
): bool {
    throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
});
set_exception_handler(function (\Throwable $exception) {
    if ($exception instanceof Framework\Exceptions\PageNotFoundException) {
        http_response_code(404);
    } else {
        http_response_code(500);
    }
    $showErrors = true;
    ini_set('log_errors', '1');
    if ($showErrors) {
        ini_set('display_errors', '1');
    } else {
        ini_set('display_errors', '0');
        require "views/500.php";
    }
    throw $exception;
});

use App\Database;
use Framework\Container;

spl_autoload_register(function (string $className) {
    $className = str_replace('\\', '/', $className);
    require "src/$className.php";
});
$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);
if ($path === false) {
    throw new \UnexpectedValueException("Mailformed URL: {$_SERVER['REQUEST_URI']}");
}
// require "src/router.php";
$router = new Framework\Router();
$router->add('/{title}/{id:\d+}/{page:\d+}', ['controller' => 'Products', 'action' => 'showPage']);
$router->add('/home/index', ['controller' => 'Home', 'action' => 'index']);
$router->add('/', ['controller' => 'Home', 'action' => 'index']);
$router->add('/products', ['controller' => 'Products', 'action' => 'index']);
$router->add('/{controller}/{id:\d+}/{action}');
$router->add('/product/{slug:[\w-]+}', ['controller' => 'products', 'action' => 'show']);
$router->add("/{controller}/{action}");
// print_r(compact('params'));

$container = new Container();
$container->set(Database::class, fn() => new Database('localhost', 'product_db', 'root', ''));
$dispatcher = new \Framework\Dispatcher($router,  $container);
$dispatcher->handle($path);
