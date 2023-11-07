<?php
class IngredientsController extends Controller
{

    private $ingredientModel;

    public function __construct()
    {
        $this->ingredientModel = $this->model('ingredientModel');
    }

    public function overview()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getIngredients = $this->ingredientModel->getActiveIngredients();
            $data = [
                'Ingredients' => $getIngredients
            ];

            $this->view('ingredients/overview', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createIngredient = $this->ingredientModel->createIngredient($post);

            if ($createIngredient) {
                header('Location: ' . URLROOT . 'ingredientscontroller/overview');
                exit();
            } else {
                header('Location: ' . URLROOT . 'ingredientscontroller/overview');
                exit();
            }
        } else {
            // Display the form
            $this->view('ingredients/create');
        }
    }

    public function delete($ingredientId)
    {
        if ($this->ingredientModel->deleteIngredient($ingredientId)) {
            header('Location: ' . URLROOT . 'ingredientsController/overview');
        } else {
            echo 'Something went wrong'; // Corrected capitalization
        }
    }

    public function update($ingredientId)
    {
        // Retrieve the selected ingredient data
        $selectedIngredient = $this->ingredientModel->getIngredientByid($ingredientId);

        if (!$selectedIngredient) {
            die('ingredient not found');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the ingredient using the retrieved POST data
            $updated = $this->ingredientModel->updateIngredient($ingredientId, $post);

            if ($updated) {
                // Product updated successfully, redirect to the product overview page
                header('Location: ' . URLROOT . 'ingredientsController/overview');
                exit;
            } else {
                // Handle the case where the update failed, e.g., show an error message.
                // You might want to add more error handling here.
                die('Ingredient update failed');
            }
        }

        // Load the update view with the selected ingredient data
        $data = [
            'Ingredient' => $selectedIngredient
        ];
        $this->view('ingredients/update', $data);
    }
}
