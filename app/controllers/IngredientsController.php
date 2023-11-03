<?php
class IngredientsController extends Controller
{

    private $ingredientModel;

    public function __construct()
    {
        $this->ingredientModel = $this->model('ingredientModel');
    }

    public function index()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getIngredients = $this->ingredientModel->getActiveIngredients();
            $data = [
                'Ingredients' => $getIngredients
            ];

            $this->view('ingredients/index', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createIngredient = $this->ingredientModel->createIngredient($post);

            if ($createIngredient) {
                echo "ingredient created successfully.";
                header("Location: " . URLROOT . 'ingredientscontroller/index');
                exit();
            } else {
                echo "Failed to create the ingredient.";
                header("Location: " . URLROOT . 'ingredientscontroller/index');
                exit();
            }
        } else {
            // Display the form
            $this->view('ingredients/index');
        }
    }

    public function delete($ingredientId)
    {
        if ($this->ingredientModel->deleteIngredient($ingredientId)) {
            header("Location: " . URLROOT . 'ingredientsController/index');
        } else {
            echo "Er is iets fout gegaan"; // Corrected capitalization
        }
    }

    public function update($ingredientId)
    {
        // Retrieve the selected ingredient data
        $selectedIngredient = $this->ingredientModel->getIngredientByid($ingredientId);

        if (!$selectedIngredient) {
            // Handle the case where the ingredient is not found, e.g., show an error message or redirect.
            // You might want to add more error handling here.
            die("ingredient not found");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the ingredient using the retrieved POST data
            $updated = $this->ingredientModel->updateIngredient($ingredientId, $post);

            if ($updated) {
                // Product updated successfully, redirect to the product index page
                header("Location: " . URLROOT . 'ingredientsController/index');
                exit;
            } else {
                // Handle the case where the update failed, e.g., show an error message.
                // You might want to add more error handling here.
                die("Ingredient update failed");
            }
        }

        // Load the update view with the selected ingredient data
        $data = [
            'Ingredient' => $selectedIngredient
        ];
        $this->view('ingredients/update', $data);
    }
}
