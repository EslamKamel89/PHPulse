<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products {
    public function index() {
        $product = new Product();
        $products = $product->getData();
        $view = new Viewer();
        echo $view->render('Products/index', ['products' => $products]);
    }
    public function show(string $id) {
        $view = new Viewer();
        echo $view->render('Products/show', ['id' => $id]);
    }
}
