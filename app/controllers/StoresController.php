<?php
class StoresController extends Controller
{

    private $storeModel;

    public function __construct()
    {
        $this->storeModel = $this->model('storeModel');
    }

    public function overview()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getStores = $this->storeModel->getActiveStores();
            $data = [
                'Stores' => $getStores
            ];

            $this->view('stores/overview', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createStore = $this->storeModel->createStore($post);

            if ($createStore) {
                header('Location: ' . URLROOT . 'storescontroller/overview');
                exit();
            } else {
                header('Location: ' . URLROOT . 'storescontroller/overview');
                exit();
            }
        } else {
            // Display the form
            $this->view('stores/create');
        }
    }

    public function delete($storeId)
    {
        if ($this->storeModel->deleteStore($storeId)) {
            header('Location: ' . URLROOT . 'storescontroller/overview');
        } else {
            echo 'Something went wrong while deleting the store.'; // Provide a more user-friendly message
        }
    }

    public function update($storeId)
    {
        // Retrieve the selected product data
        $selectedStore = $this->storeModel->getStoreById($storeId);

        if (!$selectedStore) {
            // Handle the case where the product is not found, e.g., show an error message or redirect.
            // You might want to add more error handling here.
            die('Product not found');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the product using the retrieved POST data
            $updated = $this->storeModel->updateStore($storeId, $post);

            if ($updated) {
                // Product updated successfully, redirect to the product overview page
                header('Location: ' . URLROOT . 'storescontroller/overview');
                exit;
            } else {
                die('Product update failed');
            }
        }

        // Load the update view with the selected product data
        $data = [
            'Store' => $selectedStore
        ];
        $this->view('stores/update', $data);
    }
}
