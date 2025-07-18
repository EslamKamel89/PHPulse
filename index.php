<?php
spl_autoload_register(function (string $className) {
    $className = str_replace('\\', '/', $className);

    require "src/$className.php";
});
$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);
// require "src/router.php";
$router = new Framework\Router();
$router->add("/{controller}/{action}");
$router->add('/{controller}/{id:\d+}/{action}');
$router->add('/home/index', ['controller' => 'Home', 'action' => 'index']);
$router->add('/', ['controller' => 'Home', 'action' => 'index']);
$router->add('/products', ['controller' => 'Products', 'action' => 'index']);
$params =  $router->match($path);
// print_r(compact('params'));
if (!$params) {
    exit('404 not found');
}
$action = $params['action'];
$controller = 'App\Controllers\\' . ucwords($params['controller']);
$cont = new $controller();
$cont->$action();
