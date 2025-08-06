<?php

use App\Database;
use Framework\Container;

$container = new Container();
$container->set(Database::class, fn() => new Database('localhost', 'product_db', 'root', ''));
return $container;
