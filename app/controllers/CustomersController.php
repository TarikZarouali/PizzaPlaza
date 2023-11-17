<?php

class CustomersController extends Controller
{
    // Initialize the customer model
    private $customerModel;
    private $screenModel;

    public function __construct()
    {
        // Create an instance of the customer model
        $this->customerModel = $this->model('customerModel');
        $this->screenModel = $this->model('screenModel');
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

            // Extract form data
            $customerFirstName = $post['customerFirstName'];
            $customerLastName = $post['customerLastName'];
            $customerEmail = $post['customerEmail'];
            $customerPhone = $post['customerPhone'];
            $customerAddress = $post['customerAddress'];
            $customerZipCode = $post['customerZipCode'];

            // Check if any required fields are empty
            if (
                empty($customerFirstName) || empty($customerLastName) ||
                empty($customerEmail) || empty($customerPhone) ||
                empty($customerAddress) || empty($customerZipCode)
            ) {
                // Redirect with error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Customer creation failed. Please fill in all required fields.');
                header('Location:' . URLROOT . '/customerscontroller/create/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                exit();
            } else {
                // Form data is valid; proceed with creating the customer
                $createCustomer = $this->customerModel->createCustomer($post);

                // Check if the customer creation was successful
                if ($createCustomer) {
                    // Redirect on success with a success message
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Customer creation successful.');
                    header('Location:' . URLROOT . '/customerscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                    exit();
                } else {
                    // Log the error using Helper
                    Helper::log('error', 'Customer creation failed.');
                    // Redirect on failure with an error message
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Customer creation failed. Please try again.');
                    header('Location:' . URLROOT . '/customerscontroller/create/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                    exit();
                }
            }
        } else {
            // Display the form to create a new customer
            $this->view('customers/create');
        }
    }


    public function update($customerId = null)
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
        ) {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if $post is an array before proceeding
            if (is_array($post)) {
                $result = $this->customerModel->updateCustomer($customerId, $post);

                // Check the success key in the result
                if ($result['success']) {
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Your update of the customer was successful');
                    header('Location:' . URLROOT . 'customerscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                } else {
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your update of the customer has failed');
                    header('Location:' . URLROOT . 'customerscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                }
            } else {
                // Handle the case where $post is not an array
                // You may want to log an error or display an error message
                Helper::log('error', 'Illegal string offset');
            }
        } else {
            $row = $this->customerModel->getCustomerById($customerId);
            $image = $this->screenModel->getScreenDataById($customerId, 'customer', 'main');
            if ($image !== false) {
                // Check if the necessary properties exist before accessing them
                if (property_exists(
                    $image,
                    'screenCreateDate'
                ) && property_exists($image, 'screenId')) {
                    $createDate = date('Ymd', $image->screenCreateDate);
                    $imageSrc = URLROOT . 'public/media/' . $createDate . '/' . $image->screenId . '.jpg';
                } else {
                    // Handle the case where expected properties are missing
                    $imageSrc = URLROOT . 'public/default-image.jpg';
                }
            } else {
                // Handle the case where no image data is found
                $imageSrc = URLROOT . 'public/default-image.jpg';
            }
            $data = [
                'Customer' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image
            ];
            $this->view('customers/update', $data);
        }
    }


    public function updateImage($customerId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);
        if (
            $imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false
        ) {
            $entity = 'customer';
            $this->screenModel->insertScreenImages($screenId, $customerId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'customerscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'customerscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if ($this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'customerscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'customerscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }


    public function delete($customerId)
    {
        // Delete a customer by ID
        if ($this->customerModel->deleteCustomer($customerId)) {
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Customer deletion was successful.');
            header('Location: ' . URLROOT . 'customerscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit;
        } else {
            // Log the error using Helper
            Helper::log('error', 'Customer Deletion has failed');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Customer deletion has failed.');
            header('Location:' . URLROOT . 'customerscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit;
        }

        $this->view('customers/delete');
    }
}
