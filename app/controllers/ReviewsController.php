<?php

class ReviewsController extends Controller
{
    private $reviewModel;
    private $customerModel;

    public function __construct()
    {
        $this->reviewModel = $this->model('ReviewModel');
        $this->customerModel = $this->model('CustomerModel');
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
                header('Location: ' . URLROOT . '/reviewscontroller/overview/');
                exit();
            } else {
                // If review creation failed, you can handle it here
                Helper::log('error', 'Review could not be created.');
                header('Location: ' . URLROOT . '/reviewscontroller/create/');
                exit();
            }
        } else {
            // Display the form for creating a new review with the list of active customers and entities
            $activeCustomers = $this->customerModel->getActiveCustomers(); // Retrieve active customers
            $data = [
                'Customers' => $activeCustomers,
            ];

            $this->view('reviews/create', $data);
        }
    }


    public function update($reviewId)
    {
        $selectedReview = $this->reviewModel->getReviewById($reviewId);
        $customers = $this->customerModel->getActiveCustomers();

        if (!$selectedReview) {
            Helper::log('error', 'Review ID could not be found.');
            header('Location:' . URLROOT . 'reviewscontroller/overview/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the review using the retrieved POST data
            $updated = $this->reviewModel->updateReview($reviewId, $post);

            if ($updated) {
                // Review updated successfully, redirect to the review overview page
                header('Location: ' . URLROOT . 'reviewscontroller/overview/');
                exit;
            } else {
                Helper::log('error', 'Review update failed.');
                header('Location:' . URLROOT . 'reviewscontroller/update/' . $reviewId);
                exit;
            }
        }

        // Load the update view with the selected review data
        $data = [
            'review' => $selectedReview,
            'Customers' => $customers
        ];
        $this->view('reviews/update', $data);
    }


    public function delete($reviewId)
    {
        if ($this->reviewModel->deleteReview($reviewId)) {
            header('Location:' . URLROOT . 'reviewscontroller/overview');
        } else {
            Helper::log('error', 'vehicle deletion failed.');
            header('Location:' . URLROOT . 'reviewscontroller/overview/');
            exit;
        }
    }
}
