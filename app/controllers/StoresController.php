<?php
class StoresController extends Controller
{

    private $storeModel;

    public function __construct()
    {
        $this->storeModel = $this->model('storeModel');
    }

    public function index()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getStores = $this->storeModel->getActiveStores();
            $data = [
                'Stores' => $getStores
            ];

            $this->view('stores/index', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createStore = $this->storeModel->createStore($post);

            if ($createStore) {
                echo "Product created successfully.";
                header("Location: " . URLROOT . 'storescontroller/index');
                exit();
            } else {
                echo "Failed to create the product.";
                header("Location: " . URLROOT . 'storescontroller/index');
                exit();
            }
        } else {
            // Display the form
            $this->view('stores/index');
        }
    }

    public function delete($storeId)
    {
        if ($this->storeModel->deleteStore($storeId)) {
            header("Location: " . URLROOT . 'storescontroller/index');
        } else {
            echo "Something went wrong while deleting the store."; // Provide a more user-friendly message
        }
    }

    public function update($storeId)
    {
        // Retrieve the selected product data
        $selectedStore = $this->storeModel->getStoreById($storeId);

        if (!$selectedStore) {
            // Handle the case where the product is not found, e.g., show an error message or redirect.
            // You might want to add more error handling here.
            die("Product not found");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the product using the retrieved POST data
            $updated = $this->storeModel->updateStore($storeId, $post);

            if ($updated) {
                // Product updated successfully, redirect to the product index page
                header("Location: " . URLROOT . 'storescontroller/index');
                exit;
            } else {
                // Handle the case where the update failed, e.g., show an error message.
                // You might want to add more error handling here.
                die("Product update failed");
            }
        }

        // Load the update view with the selected product data
        $data = [
            'Store' => $selectedStore
        ];
        $this->view('stores/update', $data);
    }
}
