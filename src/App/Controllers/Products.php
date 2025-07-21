<?php

namespace App\Controllers;

use App\Models\Product;

class Products {
    public function index() {
        $product = new Product();
        $products = $product->getData();
        require "views/product_index.php";
    }
    public function show(string $id) {
        require "views/product_show.php";
    }
    public function showPage(string $title, string $id, string $page) {
        print_r(compact('title', 'id', 'page'));
    }
}
