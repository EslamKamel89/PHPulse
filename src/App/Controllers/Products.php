<?php

namespace App\Controllers;

use App\Models\Product;

class Products {
    public function index() {
        // require "src/models/product.php";
        $product = new Product();
        $products = $product->getData();
        require "views/product_index.php";
    }
    public function show() {
        require "views/product_show.php";
    }
}
