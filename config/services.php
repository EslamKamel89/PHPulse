<?php

use App\Database;
use Framework\Container;

$container = new Container();
$container->set(Database::class, fn() => new Database(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
));
return $container;
