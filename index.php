<?php
$path = $_SERVER['REQUEST_URI'];
$path = parse_url($path, PHP_URL_PATH);
$segments = explode('/', $path);
$action = $segments[2] ?? null;
$controller = $segments[1] ?? null;
require "./src/controllers/$controller.php";
$cont = new $controller();
$cont->$action();
