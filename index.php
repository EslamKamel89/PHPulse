<?php
spl_autoload_register(function (string $className) {
    $className = str_replace('\\', '/', $className);

    require "src/$className.php";
});
$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);
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

$dispatcher = new \Framework\Dispatcher($router);
$dispatcher->handle($path);
