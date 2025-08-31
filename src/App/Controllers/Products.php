<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Product;
use Framework\Exceptions\PageNotFoundException;
use Framework\Viewer;
use Framework\Request;

class Products {
    private Request $request;
    public function __construct(private Viewer $viewer, private Product $product) {
    }
    public function setRequest(Request $request) {
        $this->request = $request;
    }
    public function index() {
        $products = $this->product->findAll();
        echo $this->viewer->render('shared/header', ['title' => 'Products']);
        echo $this->viewer->render('Products/index', [
            'products' => $products,
            'total' => $this->product->getTotal(),
        ]);
    }
    public function show(string $id) {
        $product = $this->getProduct($id);
        echo $this->viewer->render('shared/header', ['title' => 'Product']);
        echo $this->viewer->render('Products/show', ['product' => $product]);
    }
    public function edit(string $id) {
        $product = $this->getProduct($id);
        echo $this->viewer->render('shared/header', ['title' => 'Edit Product']);
        echo $this->viewer->render('Products/edit', ['product' => $product]);
    }
    protected function getProduct(string $id): array {
        $product = $this->product->find($id);
        if (!$product) {
            throw new PageNotFoundException();
        }
        return $product;
    }
    public function new() {
        echo $this->viewer->render('shared/header', ['title' => 'New Product']);
        echo  $this->viewer->render('Products/new');
    }
    public function create() {
        $data = [
            'name' => $this->request->post['name'],
            'description' => empty($this->request->post['description']) ? null : $this->request->post['description']
        ];
        if ($this->product->insert($data)) {
            header("Location: /products/{$this->product->getInsertId()}/show");
            exit;
        } else {
            echo $this->viewer->render('shared/header', ['title' => 'New Product']);
            echo  $this->viewer->render('Products/new', ['errors' => $this->product->getErrors()]);
        }
        // var_dump($this->product->getErrors());
    }
    public function update(string $id) {
        $product = $this->product->find($id);
        if (!$product) {
            throw new PageNotFoundException();
        }
        $data = [
            'name' => $this->request->post['name'],
            'description' => empty($this->request->post['description']) ? null : $this->request->post['description']
        ];
        if ($this->product->update($id, $data)) {
            header("Location: /products/{$id}/show");
            exit;
        } else {
            echo $this->viewer->render('shared/header', ['title' => 'Edit Product']);
            $data['id'] = $product['id'];
            echo  $this->viewer->render('Products/edit', [
                'errors' => $this->product->getErrors(),
                'product' => $data
            ]);
        }
    }
    public function delete(string $id) {
        $product = $this->getProduct($id);
        echo $this->viewer->render('shared/header', ['title' => 'Delete product']);
        echo $this->viewer->render('Products/delete', ['product' => $product]);
    }
    public function destroy(string $id) {
        $this->product->delete($id);
        header("Location: /products/index");
        exit;
    }
}
