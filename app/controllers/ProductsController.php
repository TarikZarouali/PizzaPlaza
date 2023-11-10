<?php
class ProductsController extends Controller
{

    private $productModel;

    public function __construct()
    {
        $this->productModel = $this->model('productModel');
    }

    public function overview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getProducts = $this->productModel->getActiveproducts();
            $data = [
                'Products' => $getProducts
            ];

            $this->view('products/overview', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createProduct = $this->productModel->createProduct($post);

            if ($createProduct) {
                header('Location: ' . URLROOT . 'productsController/overview/');
                exit();
            } else {
                Helper::log('error', 'Product creation failed');
                header('Location: ' . URLROOT . 'productsController/create/');
                exit();
            }
        } else {
            // Display the form
            $this->view('products/create');
        }
    }

    public function delete($productId)
    {
        if ($this->productModel->deleteProduct($productId)) {
            header('Location: ' . URLROOT . 'ProductsController/overview/');
        } else {
            Helper::log('error', 'Product deletion has failed');
            header('Location:' . URLROOT . 'productscontroller/overview/');
            exit;
        }
    }

    public function update($productId)
    {
        // Retrieve the selected product data
        $selectedProduct = $this->productModel->getProductById($productId);

        if (!$selectedProduct) {
            // Handle the case where the product is not found, e.g., show an error message or redirect.
            // You might want to add more error handling here.
            Helper::log('error', 'Could not find the Product Id');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the product using the retrieved POST data
            $updated = $this->productModel->updateProduct($productId, $post);

            if ($updated) {
                // Product updated successfully, redirect to the product overview page
                header('Location: ' . URLROOT . 'productsController/overview/');
                exit;
            } else {
                Helper::log('error', 'Product update failed');
                header('Location:' . URLROOT . 'productscontroller/update/' . $productId);
                exit;
            }
        }

        // Load the update view with the selected product data
        $data = [
            'Product' => $selectedProduct
        ];
        $this->view('products/update', $data);
    }
}