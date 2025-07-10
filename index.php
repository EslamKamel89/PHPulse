<?php
spl_autoload_register(function (string $className) {
    $className = str_replace('\\', '/', $className);
    // exit($className);
    // exit("src/$className.php");
    require "src/$className.php";
});
$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);
// require "src/router.php";
$router = new Framework\Router();
$router->add('/home/index', ['controller' => 'Home', 'action' => 'index']);
$router->add('/', ['controller' => 'Home', 'action' => 'index']);
$router->add('/products', ['controller' => 'Products', 'action' => 'index']);
$params =  $router->match($path);
if (!$params) {
    exit('404 not found');
}
$action = $params['action'];
$controller = 'App\Controllers\\' . ucwords($params['controller']);
// require "./src/controllers/$controller.php";
$cont = new $controller();
$cont->$action();
