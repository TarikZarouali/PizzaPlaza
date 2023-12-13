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
        // Initialize error messages
        $nameMessageEr = '';
        $mailMessageEr = '';
        $passwordMessageEr = '';
        $confirmPasswordMessageEr = '';
        $registerCustomerMessageEr = '';
        $requiredFieldsMessageEr = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // Extract form data
            $customerFirstName = $post['customerFirstName'];
            $customerLastName = $post['customerLastName'];
            $customerEmail = $post['customerEmail'];
            $customerPassword = $post['customerPassword'];
            $confirmCustomerPassword = $post['customerConfirmPassword'];

            // Check if any required fields are empty
            if (empty($customerFirstName) || empty($customerLastName) || empty($customerEmail) || empty($customerPassword) || empty($confirmCustomerPassword)) {
                // Set the error message
                $requiredFieldsMessageEr = 'Please fill in all the required fields';
            }

            // Validate individual fields
            if (!ctype_alpha(str_replace(' ', '', $customerFirstName)) || !ctype_alpha(str_replace(' ', '', $customerLastName))) {
                // Set the error message
                $nameMessageEr = 'First name and last name must be alphabetic!';
            }

            if (!filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
                // Set the error message
                $mailMessageEr = 'Please enter a valid email!';
            }

            // Validate password strength
            if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{6,}$/', $customerPassword)) {
                // Set the error message
                $passwordMessageEr = 'Password should have at least 6 characters, one uppercase letter, one number, and one special character!';
            }

            // Form data is valid; check for password match
            if ($customerPassword !== $confirmCustomerPassword) {
                // Set the error message
                $confirmPasswordMessageEr = 'Password confirmation does not match!';
            }

            // Form data is valid; proceed with creating the customer
            if (empty($requiredFieldsMessageEr) && empty($nameMessageEr) && empty($mailMessageEr) && empty($passwordMessageEr) && empty($confirmPasswordMessageEr)) {
                $createCustomer = $this->homepageModel->register($post);

                // Check if the customer creation was successful
                if (isset($createCustomer) && !empty($createCustomer)) {
                    // Redirect on success
                    header('Location:' . URLROOT . 'homepages/login');
                    exit;
                } else {
                    // Log the error using Helper
                    Helper::log('error', 'Customer creation failed. Error: ' . json_encode($createCustomer));
                    // Set the error message
                    $registerCustomerMessageEr = 'Something went wrong, please try again later!';
                }
            }
        }



        // Pass error messages to the view
        $data = [
            'nameMessageEr' => $nameMessageEr,
            'mailMessageEr' => $mailMessageEr,
            'passwordMessageEr' => $passwordMessageEr,
            'confirmPasswordMessageEr' => $confirmPasswordMessageEr,
            'registerCustomerMessageEr' => $registerCustomerMessageEr,
            'requiredFieldsMessageEr' => $requiredFieldsMessageEr
        ];

        // Render the view with error messages
        $this->view('homepages/register', $data);
    }

    public function login()
    {
        $this->view('homepages/login');
    }
}
