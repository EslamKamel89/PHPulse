<?php
$router = new Framework\Router();
$router->add('/{title}/{id:\d+}/{page:\d+}', ['controller' => 'Products', 'action' => 'showPage']);
$router->add('/home/index', ['controller' => 'Home', 'action' => 'index']);
$router->add('/', ['controller' => 'Home', 'action' => 'index']);
$router->add('/products', ['controller' => 'Products', 'action' => 'index']);
$router->add('/{controller}/{id:\d+}/{action}');
$router->add('/product/{slug:[\w-]+}', ['controller' => 'products', 'action' => 'show']);
$router->add("/{controller}/{action}");
return $router;
