<?php
class Promotions extends Controller
{
    private $promotionModel;
    private $screenModel;

    public function __construct()
    {
        $this->screenModel = $this->model('screenModel');
        $this->promotionModel = $this->model('promotionModel');
    }


    public function overview($params)
    {
        $pageNumber = isset($params['page']) ? intval($params['page']) : 1;

        // Set the number of records per page
        $recordsPerPage = 2;

        $offset = ($pageNumber - 1) * $recordsPerPage;

        // Get the total number of ingredients
        $promotions = $this->promotionModel->getPromotionByPagination($offset, $recordsPerPage);

        $countPromotions = $this->promotionModel->getTotalPromotionsCount();

        $totalPages = ceil($countPromotions / $recordsPerPage);

        $pageNumber = max(min($pageNumber, $totalPages), 1);

        $totalPages = ceil($countPromotions / $recordsPerPage);

        $pageNumber = max(1, min($pageNumber, $totalPages));

        // Pass data to the view
        $data = [
            'promotions' => $promotions,
            'countPromotions' => $countPromotions,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];

        $this->view('promotions/overview', $data);
    }


    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createPromotion = $this->promotionModel->createPromotion($post);

            if (!$createPromotion) {
                // Redirect on success with a success message
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Promotion creation successful');
                header('Location:' . URLROOT . 'promotions/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Promotion creation failed');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Promotion creation failed Please try again');
                header('Location:' . URLROOT . 'promotions/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            }
        } else {
            // Display the form
            $this->view('promotions/create');
        }
    }

    public function update($params)
    {
        $promotionId = $params['promotionId'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // Check if $post is an array before proceeding
            if (is_array($post)) {
                $result = $this->promotionModel->updatePromotion($promotionId, $post);

                // Check the success key in the result
                if ($result['success']) {
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Your update of the promotion was successful');
                    header('Location:' . URLROOT . 'promotions/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                } else {
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your update of the promotion has failed');
                    header('Location:' . URLROOT . 'promotions/update/' . $promotionId . '/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                }
            } else {
                // Handle the case where $post is not an array
                // You may want to log an error or display an error message
                Helper::log('error', 'Illegal string offset');
            }
        } else {

            $row = $this->promotionModel->getPromotionById($promotionId);
            $images = $this->screenModel->getMultipleScreensByEntityId($promotionId);

            foreach ($images as $image) {
                if (property_exists($image, 'screenCreateDate') && property_exists($image, 'screenId')) {
                    $createDate = date('Ymd', $image->screenCreateDate);
                    $image->imagePath = URLROOT . 'public/media/' . $createDate . '/' . $image->screenId . '.jpg';
                } else {
                    // Handle the case where expected properties are missing
                    $image->imagePath = URLROOT . 'public/default-image.jpg';
                }
            }

            // Helper::dump($images);
            // exit;

            $getActiveScreens = $this->screenModel->getActiveScreens();
            $data = [
                'promotion' => $row,
                'images' => $images,
                'screen' => $getActiveScreens
            ];
            $this->view('promotions/update', $data);
        }
    }


    public function updateImage($params)
    {
        $promotionId = $params['promotionId'];

        $totalImages = count($_FILES['file']['name']);

        for ($i = 0; $i < $totalImages; $i++) {
            $screenId = Helper::generateRandomString(4);

            // Check if the file is uploaded successfully
            if ($_FILES['file']['error'][$i] === UPLOAD_ERR_OK) {
                $imageUploaderResult = $this->imageUploader($screenId, $i);

                if ($imageUploaderResult['status'] === 200) {
                    $entity = 'promotion';

                    // Ensure that the index exists in the array before accessing it
                    $newScope = isset($_POST['screenScope'][$i]) ? $_POST['screenScope'][$i] : '';

                    // Insert the new screen images using the new function
                    $this->screenModel->insertMultipleScreenImages($screenId, $promotionId, $entity, $newScope);


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

        header('Location:' . URLROOT . '/promotions/update/{promotionId:' . $promotionId . ';' . $toast . ';' . $toasttitle . ';' . $toastmessage . '}');
    }







    public function deleteImage($params)
    {
        $screenId = $params['screenId'];

        if ($this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'promotions/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'promotions/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
        }
    }

    public function delete($params)
    {
        $promotionId = $params['promotionId'];

        if ($this->promotionModel->deletePromotion($promotionId)) {
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Promotion deletion was successful');
            header('Location:' . URLROOT . 'promotions/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit();
        } else {
            // Log the error using Helper
            Helper::log('error', 'Promotion deletion failed');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Promotion deletion failed.');
            header('Location:' . URLROOT . 'promotions/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit;
        }
    }
}