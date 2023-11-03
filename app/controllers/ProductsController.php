<?php
class ProductsController extends Controller
{

    private $productModel;

    public function __construct()
    {
        $this->productModel = $this->model('productModel');
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getProducts = $this->productModel->getActiveproducts();
            $data = [
                'Products' => $getProducts
            ];

            $this->view('products/index', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createProduct = $this->productModel->createProduct($post);

            if ($createProduct) {
                echo "Product created successfully.";
                header("Location: " . URLROOT . 'productsController/index');
                exit();
            } else {
                echo "Failed to create the product.";
                header("Location: " . URLROOT . 'productsController/index');
                exit();
            }
        } else {
            // Display the form
            $this->view('products/index');
        }
    }

    public function delete($productId)
    {
        if ($this->productModel->deleteProduct($productId)) {
            header("Location: " . URLROOT . 'ProductsController/index');
        } else {
            echo "Er is iets fout gegaan"; // Corrected capitalization
        }
    }

    public function update($productId)
    {
        // Retrieve the selected product data
        $selectedProduct = $this->productModel->getProductById($productId);

        if (!$selectedProduct) {
            // Handle the case where the product is not found, e.g., show an error message or redirect.
            // You might want to add more error handling here.
            die("Product not found");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the product using the retrieved POST data
            $updated = $this->productModel->updateProduct($productId, $post);

            if ($updated) {
                // Product updated successfully, redirect to the product index page
                header("Location: " . URLROOT . 'productsController/index');
                exit;
            } else {
                // Handle the case where the update failed, e.g., show an error message.
                // You might want to add more error handling here.
                die("Product update failed");
            }
        }

        // Load the update view with the selected product data
        $data = [
            'Product' => $selectedProduct
        ];
        $this->view('products/update', $data);
    }
}
