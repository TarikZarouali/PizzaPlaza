<?php
class PromotionsController extends Controller
{


    private $promotionModel;

    public function __construct()
    {
        $this->promotionModel = $this->model('promotionModel');
    }

    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getPromotions = $this->promotionModel->getActivePromotions();
            $data = [
                'Promotions' => $getPromotions
            ];

            $this->view('promotions/index', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createPromotion = $this->promotionModel->createPromotion($post);

            if ($createPromotion) {
                echo "Promotion created successfully.";
                header("Location: " . URLROOT . 'promotionscontroller/index');
                exit();
            } else {
                echo "Failed to create the promotion.";
                header("Location: " . URLROOT . 'promotionscontroller/index');
                exit();
            }
        } else {
            // Display the form
            $this->view('promotions/index');
        }
    }

    public function update($promotionId)
    {
        // Retrieve the selected promotion data
        $selectedPromotion = $this->promotionModel->getPromotionById($promotionId);

        if (!$selectedPromotion) {
            // Handle the case where the promotion is not found, e.g., show an error message or redirect.
            // You might want to add more error handling here.
            die("Promotion not found");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the promotion using the retrieved POST data
            $updated = $this->promotionModel->updatePromotion($promotionId, $post);

            if ($updated) {
                // Promotion updated successfully, redirect to the promotion index page
                header("Location: " . URLROOT . 'promotionscontroller/index');
                exit;
            } else {
                // Handle the case where the update failed, e.g., show an error message.
                // You might want to add more error handling here.
                die("Promotion update failed");
            }
        }

        // Load the update view with the selected promotion data
        $data = [
            'Promotion' => $selectedPromotion
        ];
        $this->view('promotions/update', $data);
    }

    public function delete($promotionId)
    {
        if ($this->promotionModel->deletePromotion($promotionId)) {
            header("Location: " . URLROOT . 'promotionscontroller/index');
        } else {
            echo "Er is iets fout gegaan"; // Corrected capitalization
        }
    }
}
