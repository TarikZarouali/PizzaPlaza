<?php
class Homepage extends Controller
{

    private $productModel;
    private $screenModel;
    private $ingredientModel;
    private $storeModel;
    private $homepageModel;

    private $customerModel;

    public function __construct()
    {
        $this->productModel = $this->model('productModel');
        $this->storeModel = $this->model('storeModel');
        $this->screenModel = $this->model('screenModel');
        $this->homepageModel = $this->model('homepageModel');
        $this->ingredientModel = $this->model('ingredientModel');
        $this->customerModel = $this->model('customerModel');
    }

    public function overview($params = null)
    {
        global $productType;

        $ingredients = $this->ingredientModel->getActiveIngredients();
        $stores = $this->storeModel->getActiveStores();

        $sortOption = isset($params['sort']) ? $params['sort'] : null;
        $keyword = isset($params['search']) ? $params['search'] : null;
        $page = isset($params['page']) ? intval($params['page']) : 1;


        $recordsPerPage = 4;

        // Calculate offset based on the current page
        $offset = ($page - 1) * $recordsPerPage;

        // Retrieve products based on pagination settings
        if (isset($sortOption) && !empty($sortOption)) {
            $productsResult = $this->homepageModel->sortProductByPrice($sortOption, $recordsPerPage, $offset);
        } elseif (isset($keyword) && !empty($keyword)) {
            $productsResult = $this->homepageModel->searchProduct($keyword, $offset, $recordsPerPage);
        } else {
            $productsResult = $this->homepageModel->getProductsByFilter($params, $offset, $recordsPerPage);
        }

        // Update countProducts for proper total pages calculation
        $countProducts = count($this->homepageModel->getProductsByFilter($params));

        // Recalculate the total number of pages
        $totalPages = ceil($countProducts / $recordsPerPage);
        $page = max(1, min($page, $totalPages));

        // Initialize $products array
        $products = [];

        if (!empty($productsResult)) {
            foreach ($productsResult as $product) {
                $productId = $product->productId;
                if (!isset($products[$productId])) {
                    $products[$productId] = $product;
                }
            }
            foreach ($products as $product) {
                $product->imagePath = $this->screenModel->getScreenImage($product->productId);
            }
        }

        $nextPage = $page < $totalPages ? $page + 1 : null;
        $prevPage = $page > 1 ? $page - 1 : null;
        $numberButtons = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $numberButtons[] = $i;
        }

        $paginationButtons = [
            'nextPage' => $nextPage,
            'prevPage' => $prevPage,
            'numberButtons' => $numberButtons
        ];

        $urlQuery = [];

        foreach ($paginationButtons as $buttonName => $buttonValue) {
            if (is_array($buttonValue)) {
                foreach ($buttonValue as $numberButton) {
                    $urlQuery[$buttonName][$numberButton] = URLROOT . "homepages/overview/{page:" . $numberButton . ";";

                    // Iterate through each key-value pair
                    foreach ($params as $key => $value) {
                        if ($key !== 'page') {
                            // Check if the key is "ingredients"
                            if (is_array($value)) {
                                // If the key is "ingredients" and the value is an array, format it as "key[value1,value2];"
                                $urlQuery[$buttonName][$numberButton] .= $key . ':[' . implode(',', $value) . '];';
                            } else {
                                // If the key is not "ingredients" or the value is not an array, append key and value to the URL format
                                $urlQuery[$buttonName][$numberButton] .= $key . ':' . $value . ';';
                            }
                        }
                    }
                    $urlQuery[$buttonName][$numberButton] .= "}";
                }
            } else {
                $urlQuery[$buttonName] = URLROOT . "homepages/overview/{page:" . $buttonValue . ";";

                // Iterate through each key-value pair
                foreach ($params as $key => $value) {
                    if ($key !== 'page') {
                        // Check if the key is "ingredients"
                        if (is_array($value)) {
                            // If the key is "ingredients" and the value is an array, format it as "key[value1,value2];"
                            $urlQuery[$buttonName] .= $key . ':[' . implode(',', $value) . '];';
                        } else {
                            // If the key is not "ingredients" or the value is not an array, append key and value to the URL format
                            $urlQuery[$buttonName] .= $key . ':' . $value . ';';
                        }
                    }
                }
                $urlQuery[$buttonName] .= "}";
            }
        }

        $data = [
            'ingredients' => $ingredients,
            'productTypes' => $productType,
            'stores' => $stores,
            'products' => $products,
            'params' => $params,
            'totalProducts' => $countProducts,
            'currentPage' => $page,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
            'urlQuery' => $urlQuery
        ];

        $this->view('homepages/overview', $data);
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
            $confirmCustomerPassword = $post['customerConfirmPassword'];

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


            // Validate password strength
            if (!empty($customerPassword) && !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{6,}$/', $customerPassword)) {
                // Set the error message
                unset($ajaxResponse['success']);
                $ajaxResponse['customerPassword'] = [
                    'state' => 500,
                    'message' => 'password must atleast have 6 charachters, one special charachter and one uppercase charachter'
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

            // Form data is valid; check for password match
            if (!empty($customerConfirmPassword) && $customerConfirmPassword !== $confirmCustomerPassword) {
                // Set the error message
                unset($ajaxResponse['success']);
                $ajaxResponse['customerConfirmPassword'] = [
                    'state' => 500,
                    'message' => 'passwords must match!'
                ];
            }

            // Form data is valid; proceed with creating the customer
            if (empty($requiredFieldsMessageEr) && empty($nameMessageEr) && empty($mailMessageEr) && empty($passwordMessageEr) && empty($confirmPasswordMessageEr)) {
                $createCustomer = $this->homepageModel->register($post);

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
        $this->view('homepages/register');
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
                $userExists = $this->homepageModel->checkUserExist($customerEmail, $customerPassword);

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
        $this->view('homepages/login');
    }

    public function logout()
    {
        session_start();
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to the login page or any other page as needed
        header('Location:' . URLROOT . 'homepages/overview/');
        exit();
    }
}