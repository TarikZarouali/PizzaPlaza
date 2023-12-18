<?php
class Users extends Controller
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('userModel');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $ajaxResponse = [
                'success' => [
                    'state' => 200,
                    'message' => 'Succesfully signed up!'
                ]
            ];

            // Extract form data
            $customerEmail = $post['customerEmail'];
            $customerPassword = $post['customerPassword'];
            $customerConfirmPassword = $post['customerConfirmPassword'];

            // Check if any required fields are empty
            if (empty($post['customerFirstName'])) {
                $ajaxResponse['customerFirstName'] = [
                    'state' => 500,
                    'message' => 'First name cannot be empty.'
                ];
            }

            if (empty($post['customerLastName'])) {
                $ajaxResponse['customerLastName'] = [
                    'state' => 500,
                    'message' => 'Last name cannot be empty.'
                ];
            }

            if (empty($post['customerEmail'])) {
                $ajaxResponse['customerEmail'] = [
                    'state' => 500,
                    'message' => 'Email cannot be empty.'
                ];
            }

            if (empty($post['customerPassword'])) {
                $ajaxResponse['customerPassword'] = [
                    'state' => 500,
                    'message' => 'Password cannot be empty.'
                ];
            }

            if (empty($post['customerConfirmPassword'])) {
                unset($ajaxResponse['success']);
                $ajaxResponse['customerConfirmPassword'] = [
                    'state' => 500,
                    'message' => 'Confirm password cannot be empty.'
                ];
            }


            if (!empty($customerEmail) && !filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
                // Set the error message
                unset($ajaxResponse['success']);
                $ajaxResponse['customerEmail'] = [
                    'state' => 500,
                    'message' => 'Please enter a valid email!'
                ];
            }

            // Validate password strength
            if (!empty($customerPassword) && !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{6,}$/', $customerPassword)) {
                // Set the error message
                unset($ajaxResponse['success']);
                $ajaxResponse['customerPassword'] = [
                    'state' => 500,
                    'message' => 'password must atleast have 6 charachters, one special charachter and one uppercase charachter'
                ];
            }


            // Form data is valid; check for password match
            if (!empty($customerConfirmPassword) && $customerConfirmPassword !== $customerPassword) {


                // Set the error message
                unset($ajaxResponse['success']);
                $ajaxResponse['customerConfirmPassword'] = [
                    'state' => 500,
                    'message' => 'Passwords must match!'
                ];
            }

            // Form data is valid; proceed with creating the customer
            if (empty($requiredFieldsMessageEr) && empty($nameMessageEr) && empty($mailMessageEr) && empty($passwordMessageEr) && empty($confirmPasswordMessageEr)) {
                $createCustomer = $this->userModel->register($post);

                // Check if the customer creation was successful
                if (!isset($createCustomer) && empty($createCustomer)) {
                    // Log the error using Helper
                    Helper::log('error', 'Customer creation failed. Error: ' . json_encode($createCustomer));
                }
            }

            echo json_encode($ajaxResponse);
            exit;
        }
        // Render the view with error messages
        $this->view('users/register');
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $ajaxResponse = [
                'success' => [
                    'state' => 200,
                    'message' => 'Successfully logged in!'
                ]
            ];

            $customerEmail = $post['customerEmail'];
            $customerPassword = $post['customerPassword'];

            // CHECK FOR EMPTY FIELDS
            if (empty($post['customerEmail'])) {
                unset($ajaxResponse['success']);
                $ajaxResponse['customerEmail'] = [
                    'state' => 500,
                    'message' => 'Please fill in your email!'
                ];
            }

            if (empty($post['customerPassword'])) {
                unset($ajaxResponse['success']);
                $ajaxResponse['customerPassword'] = [
                    'state' => 500,
                    'message' => 'Please fill in your password!'
                ];
            }

            if (isset($post['customerEmail']) && !empty($post['customerEmail']) && isset($post['customerPassword']) && !empty($post['customerPassword'])) {
                $userExists = $this->userModel->checkUserExist($customerEmail, $customerPassword);

                if (isset($userExists) && !empty($userExists)) {
                    session_start();
                    $_SESSION['user'] = $userExists;
                    session_write_close();
                } else {
                    unset($ajaxResponse['success']);
                    $ajaxResponse['loginFailed'] = [
                        'state' => 500,
                        'message' => 'Email or password is incorrect'
                    ];
                }
            }

            echo json_encode($ajaxResponse);
            exit;
        }
        $this->view('users/login');
    }

    public function logout()
    {
        session_start();


        // Destroy the session
        session_destroy();

        // Redirect to the login page or any other page as needed
        header('Location:' . URLROOT . 'homepages/overview/');
        exit();
    }

    public function userSettings()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $ajaxResponse = [
                'success' => [
                    'state' => 200,
                    'message' => 'Successfully logged in!'
                ]
            ];

            if (empty($post['customerPhone'])) {
                unset($ajaxResponse['success']);
                $ajaxResponse['customerPhone'] = [
                    'state' => 500,
                    'message' => 'Please fill in your password!'
                ];
            }

            if (isset($ajaxResponse['success'])) {
                $this->userModel->editUser($post);
                session_start();

                $_SESSION['user']->customerFirstName = $post['customerFirstName'];
                $_SESSION['user']->customerLastName = $post['customerLastName'];
                $_SESSION['user']->customerEmail = $post['customerEmail'];
                $_SESSION['user']->customerPassword = $post['customerPassword'];
                $_SESSION['user']->customerPhone = $post['customerPhone'];
                $_SESSION['user']->customerAddress = $post['customerAddress'];
                $_SESSION['user']->customerZipCode = $post['customerZipCode'];

                session_write_close();
                echo json_encode($ajaxResponse);
                exit;
            } else {
                helper::log('error', 'error at editing the User');
                return false;
            }
        }

        $this->view('users/usersettings');
    }
}
