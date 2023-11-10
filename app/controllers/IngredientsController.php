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
                header('Location: ' . URLROOT . 'ingredientscontroller/overview/');
                exit();
            } else {
                Helper::log('error', 'ingredient creation failed.');
                header('Location: ' . URLROOT . 'ingredientscontroller/create/');
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
            header('Location: ' . URLROOT . 'ingredientsController/overview/');
        } else {
            Helper::log('error', 'ingredient deletion failed.');
            header('Location:' . URLROOT . 'ingredientscontroller/overview/');
            exit;
        }
    }

    public function update($ingredientId)
    {
        // Retrieve the selected ingredient data
        $selectedIngredient = $this->ingredientModel->getIngredientById($ingredientId);

        if (!$selectedIngredient) {
            Helper::log('error', 'ingredient ID not found');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the ingredient using the retrieved POST data
            $updateIngredient = $this->ingredientModel->updateIngredient($ingredientId, $post);

            if ($updateIngredient) {
                // Product updated successfully, redirect to the product overview page
                header('Location: ' . URLROOT . 'ingredientsController/overview');
                exit;
            } else {
                // Handle the case where the update failed, e.g., show an error message.
                // You might want to add more error handling here.
                Helper::log('error', 'ingredient update failed.');
                header('Location:' . URLROOT . 'ingredientscontroller/update/' . $ingredientId);
                exit;
            }
        }
        // Load the update view with the selected ingredient data
        $data = [
            'Ingredient' => $selectedIngredient
        ];
        $this->view('ingredients/update', $data);
    }
}