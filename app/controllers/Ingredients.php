<?php
class Ingredients extends Controller
{

    private $ingredientModel;
    private $screenModel;

    public function __construct()
    {
        $this->screenModel = $this->model('screenModel');
        $this->ingredientModel = $this->model('ingredientModel');
    }

    public function overview($params)
    {
        $pageNumber = isset($params['page']) ? intval($params['page']) : 1;

        // Set the number of records per page
        $recordsPerPage = 2;

        $offset = ($pageNumber - 1) * $recordsPerPage;

        // Get the total number of ingredients
        $ingredients = $this->ingredientModel->getIngredientsByPagination($offset, $recordsPerPage);

        $countIngredients = $this->ingredientModel->getTotalIngredientsCount();

        $totalPages = ceil($countIngredients / $recordsPerPage);

        $pageNumber = max(min($pageNumber, $totalPages), 1);

        $totalPages = ceil($countIngredients / $recordsPerPage);

        $pageNumber = max(1, min($pageNumber, $totalPages));

        // Pass data to the view
        $data = [
            'ingredients' => $ingredients,
            'countIngredients' => $countIngredients,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];

        $this->view('ingredients/overview', $data);
    }







    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createIngredient = $this->ingredientModel->createIngredient($post);

            if ($createIngredient) {
                // Redirect on success with a success message
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Ingredient creation successful');
                header('Location:' . URLROOT . 'ingredients/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Ingredient creation failed');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Ingredient creation failed. Please try again.');
                header('Location:' . URLROOT . 'ingredients/create/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            }
        } else {
            // Display the form
            $this->view('ingredients/create');
        }
    }

    public function delete($params)
    {
        $ingredientId = $params['ingredientId'];
        if ($this->ingredientModel->deleteIngredient($ingredientId)) {
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Ingredient deletion was successful');
            header('Location:' . URLROOT . 'ingredients/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit();
        } else {
            // Log the error using Helper
            Helper::log('error', 'Ingredient deletion failed');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Ingredient deletion failed');
            header('Location:' . URLROOT . 'ingredients/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit;
        }
    }

    public function update($params)
    {

        $ingredientId = $params['ingredientId'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if $post is an array before proceeding
            if (is_array($post)) {
                $result = $this->ingredientModel->updateIngredient($ingredientId, $post);

                // Check the success key in the result
                if ($result['success']) {
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Your update of the ingredient was successful');
                    header('Location:' . URLROOT . 'ingredients/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                } else {
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your update of the ingredient has failed');
                    header('Location:' . URLROOT . 'ingredients/update/' . $ingredientId .  '/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                }
            } else {
                // Handle the case where $post is not an array
                // You may want to log an error or display an error message
                Helper::log('error', 'Illegal string offset');
            }
        } else {
            $row = $this->ingredientModel->getIngredientById($ingredientId);
            $image = $this->screenModel->getScreenDataById($ingredientId, 'ingredient', 'main');
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
            $data = [
                'Ingredient' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image
            ];
            $this->view('ingredients/update', $data);
        }
    }


    public function updateImage($params)
    {
        $ingredientId = $params['ingredientId'];
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);
        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'ingredient';
            $this->screenModel->insertScreenImages($screenId, $ingredientId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . '/ingredients/update/{ingredientId:' . $ingredientId . ';' . $toast . ';' . $toasttitle . ';' . $toastmessage . '}');
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . '/ingredients/update/{ingredientId:' . $ingredientId . ';' . $toast . ';' . $toasttitle . ';' . $toastmessage . '}');
        }
    }

    public function deleteImage($params)
    {
        $screenId = $params['screenId'];
        // Call the deleteScreen method from the model
        if ($this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'ingredients/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'ingredients/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
        }
        // Redirect to the overview page
    }
}
