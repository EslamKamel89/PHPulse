<?php
class Products {
    public function index() {
        require "src/models/product.php";
        $product = new Product();
        $products = $product->getData();
        require "views/product_index.php";
    }
}
