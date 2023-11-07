<?php
class PromotionsController extends Controller
{


    private $promotionModel;

    public function __construct()
    {
        $this->promotionModel = $this->model('promotionModel');
    }

    public function overview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getPromotions = $this->promotionModel->getActivePromotions();
            $data = [
                'Promotions' => $getPromotions
            ];



            $this->view('promotions/overview', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createPromotion = $this->promotionModel->createPromotion($post);

            if ($createPromotion) {
                header('Location: ' . URLROOT . 'promotionscontroller/overview');
                exit();
            } else {
                header('Location: ' . URLROOT . 'promotionscontroller/overview');
                exit();
            }
        } else {
            // Display the form
            $this->view('promotions/create');
        }
    }

    public function update($promotionId)
    {
        // Retrieve the selected promotion data
        $selectedPromotion = $this->promotionModel->getPromotionById($promotionId);

        if (!$selectedPromotion) {
            // Handle the case where the promotion is not found, e.g., show an error message or redirect.
            // You might want to add more error handling here.
            die('Promotion not found');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the promotion using the retrieved POST data
            $updated = $this->promotionModel->updatePromotion($promotionId, $post);

            if ($updated) {
                // Promotion updated successfully, redirect to the promotion overview page
                header('Location: ' . URLROOT . 'promotionscontroller/overview');
                exit;
            } else {
                // Handle the case where the update failed, e.g., show an error message.
                // You might want to add more error handling here.
                die('Promotion update failed');
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
            header('Location: ' . URLROOT . 'promotionscontroller/overview');
        } else {
            echo 'Something went wrong.'; // Corrected capitalization
        }
    }
}
