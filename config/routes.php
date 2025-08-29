<?php
$router = new Framework\Router();
$router->add('/{title}/{id:\d+}/{page:\d+}', ['controller' => 'Products', 'action' => 'showPage']);
$router->add('/home/index', ['controller' => 'Home', 'action' => 'index']);
$router->add('/', ['controller' => 'Home', 'action' => 'index']);
$router->add('/products', ['controller' => 'Products', 'action' => 'index']);
$router->add('/products/new', ['controller' => 'Products', 'action' => 'new']);
// $router->add('/{controller}/{id:\d+}/{action}');
$router->add('/{controller}/{id:\d+}/show', ['action' => 'show']);
$router->add('/{controller}/{id:\d+}/edit', ['action' => 'edit']);
$router->add('/{controller}/{id:\d+}/update', ['action' => 'update']);
$router->add('/{controller}/{id:\d+}/delete', ['action' => 'delete']);
$router->add('/{controller}/{id:\d+}/destroy', ['action' => 'destroy', 'method' => 'post']);
// $router->add('/product/{slug:[\w-]+}', ['controller' => 'products', 'action' => 'show']);
$router->add("/{controller}/{action}");
return $router;
