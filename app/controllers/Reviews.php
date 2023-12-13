<?php

class Reviews extends Controller
{
    private $reviewModel;
    private $customerModel;
    private $storeModel;
    private $orderModel;
    private $productModel;
    private $screenModel;

    public function __construct()
    {
        $this->reviewModel = $this->model('ReviewModel');
        $this->customerModel = $this->model('CustomerModel');
        $this->storeModel = $this->model('storeModel');
        $this->orderModel = $this->model('orderModel');
        $this->screenModel = $this->model('screenModel');
        $this->productModel = $this->model('productModel');
    }


    public function overview($params)
    {
        $pageNumber = isset($params['page']) ? intval($params['page']) : 1;

        // Set the number of records per page
        $recordsPerPage = 2;

        $offset = ($pageNumber - 1) * $recordsPerPage;

        // Get the total number of ingredients
        $reviews = $this->reviewModel->getReviewsByPagination($offset, $recordsPerPage);

        $countReviews = $this->reviewModel->getTotalReviewsCount();

        $totalPages = ceil($countReviews / $recordsPerPage);

        $pageNumber = max(min($pageNumber, $totalPages), 1);

        $totalPages = ceil($countReviews / $recordsPerPage);

        $pageNumber = max(1, min($pageNumber, $totalPages));

        // Pass data to the view
        $data = [
            'reviews' => $reviews,
            'countReviews' => $countReviews,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];

        $this->view('reviews/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            // Validate and process the form data, and insert a new review into the database
            $createReview = $this->reviewModel->createReview($post);

            if ($createReview) {
                // Redirect on success with a success message
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Review creation successful');
                header('Location:' . URLROOT . 'reviews/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Review could not be created');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Review creation failed. Please try again');
                header('Location:' . URLROOT . 'reviews/create/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            }
        } else {
            // Display the form for creating a new review with the list of active customers and entities
            $activeCustomers = $this->customerModel->getActiveCustomers();
            $activeStores = $this->storeModel->getActiveStores();
            $ActiveOrders = $this->orderModel->getActiveOrders();
            $ActiveProducts = $this->productModel->getActiveProducts();
            $data = [
                'Customers' => $activeCustomers,
                'Stores' => $activeStores,
                'Orders' => $ActiveOrders,
                'Products' => $ActiveProducts
            ];

            $this->view('reviews/create', $data);
        }
    }


    public function update($params)
    {
        $reviewId = $params['reviewId'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if $post is an array before proceeding
            if (is_array($post)) {
                $result = $this->reviewModel->updateReview($reviewId, $post);

                // Check the success key in the result
                if (!$result['success']) {
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Your update of the review was successful');
                    header('Location:' . URLROOT . 'reviews/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                } else {
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your update of the store has failed');
                    header('Location:' . URLROOT . 'reviews/update/' . $reviewId . '/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                }
            } else {
                // Handle the case where $post is not an array
                Helper::log('error', 'Illegal string offset');
            }
        } else {
            $row = $this->reviewModel->getReviewById($reviewId);
            $images = $this->screenModel->getMultipleScreensByEntityId($reviewId);


            foreach ($images as $image) {
                if (property_exists($image, 'screenCreateDate') && property_exists($image, 'screenId')) {
                    $createDate = date('Ymd', $image->screenCreateDate);
                    $image->imagePath = URLROOT . 'public/media/' . $createDate . '/' . $image->screenId . '.jpg';
                } else {
                    // Handle the case where expected properties are missing
                    $image->imagePath = URLROOT . 'public/default-image.jpg';
                }
            }

            $customer = $this->customerModel->getActiveCustomers();
            $activeStores = $this->storeModel->getActiveStores();
            $ActiveOrders = $this->orderModel->getActiveOrders();
            $ActiveProducts = $this->productModel->getActiveProducts();
            $getActiveScreens = $this->screenModel->getActiveScreens();

            $data = [
                'images' => $images,
                'review' => $row,
                'Customer' => $customer,
                'Stores' => $activeStores,
                'Orders' => $ActiveOrders,
                'Products' => $ActiveProducts,
                'screen' => $getActiveScreens
            ];
            $this->view('reviews/update', $data);
        }
    }


    public function updateImage($params)
    {
        $reviewId = $params['reviewId'];

        $totalImages = count($_FILES['file']['name']);

        for ($i = 0; $i < $totalImages; $i++) {
            $screenId = Helper::generateRandomString(4);

            // Check if the file is uploaded successfully
            if ($_FILES['file']['error'][$i] === UPLOAD_ERR_OK) {
                $imageUploaderResult = $this->imageUploader($screenId, $i);

                if ($imageUploaderResult['status'] === 200) {
                    $entity = 'review';

                    // Ensure that the index exists in the array before accessing it
                    $newScope = isset($_POST['screenScope'][$i]) ? $_POST['screenScope'][$i] : '';

                    // Insert the new screen images using the new function
                    $this->screenModel->insertMultipleScreenImages($screenId, $reviewId, $entity, $newScope);


                    // Success toast and redirection
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Your creation of the image was successful');
                } else {
                    // Failure handling
                    Helper::log('error', $imageUploaderResult);
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your creation of the image has failed');
                }
            } else {
                // Handle file upload error
                Helper::log('error', 'File upload error: ' . $_FILES['file']['error'][$i]);
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('File upload error');
            }
        }

        header('Location:' . URLROOT . '/reviews/update/{reviewId:' . $reviewId . ';' . $toast . ';' . $toasttitle . ';' . $toastmessage . '}');
    }


    public function deleteImage($params)
    {
        $screenId = $params['screenId'];

        // Call the deleteScreen method from the model
        if ($this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'reviews/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'reviews/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
        }
    }


    public function delete($params)
    {
        $reviewId = $params['reviewId'];

        if ($this->reviewModel->deleteReview($reviewId)) {
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Review deletion was successful');
            header('Location:' . URLROOT . 'reviews/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit;
        } else {
            // Log the error using Helper
            Helper::log('error', 'Review deletion failed');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Review deletion failed.');
            header('Location:' . URLROOT . 'reviews/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit;
        }
    }
}
