<?php

class CustomersController extends Controller
{
    // Initialize the customer model
    private $customerModel;

    public function __construct()
    {
        // Create an instance of the customer model
        $this->customerModel = $this->model('customerModel');
    }

    public function overview()
    {
        // Check if the request method is GET
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Get a list of active customers
            $getActiveCustomers = $this->customerModel->getActiveCustomers();
            $data = [
                'Customers' => $getActiveCustomers
            ];

            // Load the view to display the list of customers
            $this->view('customers/overview', $data);
        }
    }


    public function create()
    {
        // Check if the request method is POST (form submission)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createCustomer = $this->customerModel->createCustomer($post);

            // Check if the customer creation was successful
            if ($createCustomer) {
                header('Location: ' . URLROOT . 'customerscontroller/overview/');
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Customer creation failed.');
                // Use header to redirect on failure
                header('Location: ' . URLROOT . 'customerscontroller/create/');
                exit();
            }
        } else {
            // Display the form to create a new customer
            $this->view('customers/create');
        }
    }

    public function update($customerId)
    {
        // Retrieve the selected customer data by ID
        $selectedCustomer = $this->customerModel->getCustomerById($customerId);

        if (!$selectedCustomer) {
            // Handle the case where the customer is not found
            Helper::log('error', 'Customer Id could not have been found.');
            exit;
        }
        // Check if the request method is POST (form submission)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate the submitted POST data
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the customer using the retrieved POST data
            $updatedCustomer = $this->customerModel->updateCustomer($customerId, $post);

            // Check if the update was successful
            if ($updatedCustomer) {
                // Redirect to the customer overview page
                header('Location: ' . URLROOT . 'customersController/overview/');
                exit;
            } else {
                Helper::log('error', 'Customer update failed.');
                header('Location: ' . URLROOT . 'customerscontroller/update/' . $customerId);
                exit;
            }
        }

        // Load the view to update the customer with the selected data
        $data = [
            'Customer' => $selectedCustomer
        ];
        $this->view('customers/update', $data);
    }

    public function delete($customerId)
    {
        // Delete a customer by ID
        if ($this->customerModel->deleteCustomer($customerId)) {
            header('Location: ' . URLROOT . 'customerscontroller/overview/');
        } else {
            Helper::log('error', 'Customer Deletion has failed');
            header('Location:' . URLROOT . 'customerscontroller/overview/');
            exit;
        }
    }
}
