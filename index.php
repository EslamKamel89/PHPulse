<?php
require "./src/controllers/products.php";
$controller = new Products();
$action = $_GET['action'] ?? null;
if ($action === 'index') {
    $controller->index();
} elseif ($action == 'show') {
    $controller->show();
} else {
    echo  '404 not found';
}
