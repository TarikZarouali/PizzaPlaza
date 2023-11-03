<?php
class CustomersController extends Controller
{


    private $customerModel;

    public function __construct()
    {
        $this->customerModel = $this->model('customerModel');
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getCustomers = $this->customerModel->getActiveCustomers();
            $data = [
                'Customers' => $getCustomers
            ];

            $this->view('customers/index', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createCustomer = $this->customerModel->createCustomer($post);

            if ($createCustomer) {
                echo "customer created successfully.";
                header("Location: " . URLROOT . 'customerscontroller/index');
                exit();
            } else {
                echo "Failed to create the customer.";
                header("Location: " . URLROOT . 'customerscontroller/index');
                exit();
            }
        } else {
            // Display the form
            $this->view('customers/index');
        }
    }

    public function update($customerId)
    {
        // Retrieve the selected customer data
        $selectedCustomer = $this->customerModel->getCustomerById($customerId);

        if (!$selectedCustomer) {
            // Handle the case where the customer is not found, e.g., show an error message or redirect.
            // You might want to add more error handling here.
            die("customer not found");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the customer using the retrieved POST data
            $updated = $this->customerModel->updateCustomer($customerId, $post);

            if ($updated) {
                // customer updated successfully, redirect to the customer index page
                header("Location: " . URLROOT . 'customersController/index');
                exit;
            } else {
                // Handle the case where the update failed, e.g., show an error message.
                // You might want to add more error handling here.
                die("Customer update failed");
            }
        }

        // Load the update view with the selected customer data
        $data = [
            'Customer' => $selectedCustomer
        ];
        $this->view('customers/update', $data);
    }



    public function delete($customerId)
    {
        if ($this->customerModel->deleteCustomer($customerId)) {
            header("Location: " . URLROOT . 'customerscontroller/index');
        } else {
            echo "Er is iets fout gegaan"; // Corrected capitalization
        }
    }
}
