<?php
class ProductsController extends Controller
{

    private $productModel;
    private $customerModel;

    public function __construct()
    {
        $this->productModel = $this->model('productModel');
        $this->customerModel = $this->model('customerModel');
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
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $productOwner = ($post['productOwner']);
            $productName = ($post['productName']);
            $productDescription = ($post['productDescription']);
            $productPrice = ($post['productPrice']);
            $productType = ($post['productType']);

            if (
                empty($productOwner) || empty($productName) ||
                empty($productDescription) || empty($productPrice) ||
                empty($productType)
            ) {
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Your create of the customer has failed');
                header('Location:' . URLROOT . '/productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            } else {
                // Form data is valid; proceed with creating the customer
                $this->productModel->createProduct($post);
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Your create of the customer was successful');

                header('Location:' . URLROOT . '/productscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            }
        } else {
            $activeCustomers = $this->customerModel->getactiveCustomers(); // Retrieve active stores
            $data = [
                'Customers' => $activeCustomers,
            ];

            $this->view('products/create', $data);
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
