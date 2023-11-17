<?php

class ReviewsController extends Controller
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

    public function overview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getReviews = $this->reviewModel->getActiveReviews();

            $getActiveCustomers = $this->customerModel->getActiveCustomers();

            $data = [
                'Reviews' => $getReviews,
                'Customers' => $getActiveCustomers
            ];

            $this->view('reviews/overview', $data);
        }
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
                $toastmessage = urlencode('Review creation successful.');
                header('Location: ' . URLROOT . '/reviewscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Review could not be created.');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Review creation failed. Please try again.');
                header('Location: ' . URLROOT . '/reviewscontroller/create/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
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


    public function update($reviewId = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if $post is an array before proceeding
            if (is_array($post)) {
                $result = $this->reviewModel->updateReview($reviewId, $post);

                // Check the success key in the result
                if ($result['success']) {
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Your update of the review was successful');
                    header('Location:' . URLROOT . 'reviewscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                } else {
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your update of the store has failed');
                    header('Location:' . URLROOT . 'reviewscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                }
            } else {
                // Handle the case where $post is not an array
                // You may want to log an error or display an error message
                Helper::log('error', 'Illegal string offset');
            }
        } else {
            $row = $this->reviewModel->getReviewById($reviewId);
            $image = $this->screenModel->getScreenDataById($reviewId, 'review', 'main');
            if ($image !== false) {
                // Check if the necessary properties exist before accessing them
                if (property_exists($image, 'screenCreateDate') && property_exists($image, 'screenId')) {
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
            $customer = $this->customerModel->getActiveCustomers();
            $data = [
                'review' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image,
                'Customer' => $customer
            ];
            $this->view('reviews/update', $data);
        }
    }


    public function updateImage($reviewId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);
        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'review';
            $this->screenModel->insertScreenImages($screenId, $reviewId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'reviewscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'reviewscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if ($this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'reviewscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'reviewscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
        // Redirect to the overview page
    }


    public function delete($reviewId)
    {
        if ($this->reviewModel->deleteReview($reviewId)) {
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Review deletion was successful.');
            header('Location:' . URLROOT . 'reviewscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit;
        } else {
            // Log the error using Helper
            Helper::log('error', 'Review deletion failed.');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Review deletion failed.');
            header('Location:' . URLROOT . 'reviewscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit;
        }
    }
}
