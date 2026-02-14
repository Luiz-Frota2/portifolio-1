<?php
// app/controllers/ProductsController.php

class ProductsController extends Controller {
    
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login');
        }
    }
    
    public function index() {
        $productModel = $this->model('Product');
        $products = $productModel->getAll();
        
        $this->view('products/index', ['view' => 'products/index', 'products' => $products]);
    }

    public function create() {
        $productModel = $this->model('Product');
        $categories = $productModel->getCategories();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'categoria_id' => $_POST['categoria_id'],
                'nome' => $_POST['nome'],
                'codigo_interno' => $_POST['codigo_interno'],
                'codigo_barras' => $_POST['codigo_barras'],
                'ncm' => $_POST['ncm'],
                'unidade' => $_POST['unidade'],
                'preco_custo' => str_replace(',', '.', $_POST['preco_custo']),
                'preco_venda' => str_replace(',', '.', $_POST['preco_venda']),
                'preco_prefeitura' => str_replace(',', '.', $_POST['preco_prefeitura']),
                'preco_avista' => str_replace(',', '.', $_POST['preco_avista'])
            ];

            if ($productModel->create($data)) {
                 $this->redirect('products/index');
            }
        }
        
        $this->view('products/form', ['view' => 'products/form', 'categories' => $categories, 'action' => 'create']);
    }

    public function edit($id) {
        $productModel = $this->model('Product');
        $product = $productModel->getById($id);
        $categories = $productModel->getCategories();
        $estoque = $productModel->getEstoque($id);

        if (!$product) {
            $this->redirect('products/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $data = [
                'categoria_id' => $_POST['categoria_id'],
                'nome' => $_POST['nome'],
                'codigo_interno' => $_POST['codigo_interno'],
                'codigo_barras' => $_POST['codigo_barras'],
                'ncm' => $_POST['ncm'],
                'unidade' => $_POST['unidade'],
                'preco_custo' => str_replace(',', '.', $_POST['preco_custo']),
                'preco_venda' => str_replace(',', '.', $_POST['preco_venda']),
                'preco_prefeitura' => str_replace(',', '.', $_POST['preco_prefeitura']),
                'preco_avista' => str_replace(',', '.', $_POST['preco_avista'])
            ];

            if ($productModel->update($id, $data)) {
                 $this->redirect('products/index');
            }
        }

        $this->view('products/form', [
            'view' => 'products/form', 
            'product' => $product, 
            'categories' => $categories, 
            'estoque' => $estoque,
            'action' => 'edit'
        ]);
    }
}
