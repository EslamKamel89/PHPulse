<?php
require "./src/controllers/products.php";
$products = new Products();
$products->index();
