<?php

namespace App\Controllers;

use App\Models\Product;
use Framework\Viewer;

class Products {
    public function __construct(private Viewer $viewer) {
    }
    public function index() {
        $product = new Product();
        $products = $product->getData();
        echo $this->viewer->render('shared/header', ['title' => 'Products']);
        echo $this->viewer->render('Products/index', ['products' => $products]);
    }
    public function show(string $id) {
        echo $this->viewer->render('shared/header', ['title' => 'Product']);
        echo $this->viewer->render('Products/show', ['id' => $id]);
    }
}
