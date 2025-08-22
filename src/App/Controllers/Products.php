<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Exceptions\PageNotFoundException;
use Framework\Viewer;

class Products {
    public function __construct(private Viewer $viewer, private Product $product) {
    }
    public function index() {
        $products = $this->product->findAll();
        echo $this->viewer->render('shared/header', ['title' => 'Products']);
        echo $this->viewer->render('Products/index', ['products' => $products]);
    }
    public function show(string $id) {
        $product = $this->product->find($id);
        if (!$product) {
            throw new PageNotFoundException();
        }
        echo $this->viewer->render('shared/header', ['title' => 'Product']);
        echo $this->viewer->render('Products/show', ['product' => $product]);
    }
    public function new() {
        echo $this->viewer->render('shared/header', ['title' => 'New Product']);
        echo  $this->viewer->render('Products/new');
    }
    public function create() {
        $data = [
            'name' => $_POST['name'],
            'description' => empty($_POST['description']) ? null : $_POST['description']
        ];
        if ($this->product->insert($data)) {
            echo  "record saved.";
        } else {
            echo $this->viewer->render('shared/header', ['title' => 'New Product']);
            echo  $this->viewer->render('Products/new', ['errors' => $this->product->getErrors()]);
        }
        // var_dump($this->product->getErrors());
    }
}
