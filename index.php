<?php
$action = $_GET['action'] ?? null;
$controller = $_GET['controller'] ?? null;
require "./src/controllers/$controller.php";
// php is not case senstive when create new objects of a class
// new Home will work the same as new Home()
$cont = new $controller();
$cont->$action();
