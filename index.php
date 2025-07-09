<?php
$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);
require "src/router.php";
$router = new Router();
$router->add('/home/index', ['controller' => 'home', 'action' => 'index']);
$router->add('/', ['controller' => 'home', 'action' => 'index']);
$router->add('/products', ['controller' => 'Products', 'action' => 'index']);
$params =  $router->match($path);
if (!$params) {
    exit('404 not found');
}
$action = $params['action'];
$controller = $params['controller'];
require "./src/controllers/$controller.php";
$cont = new $controller();
$cont->$action();
