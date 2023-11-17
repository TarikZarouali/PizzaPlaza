<?php
class PromotionsController extends Controller
{
    private $promotionModel;
    private $screenModel;

    public function __construct()
    {
        $this->screenModel = $this->model('screenModel');
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
                // Redirect on success with a success message
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Promotion creation successful.');
                header('Location: ' . URLROOT . 'promotionscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Promotion creation failed');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Promotion creation failed. Please try again.');
                header('Location: ' . URLROOT . 'promotionscontroller/create/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                exit();
            }
        } else {
            // Display the form
            $this->view('promotions/create');
        }
    }

    public function update($promotionId = null)
    {
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
                    header('Location:' . URLROOT . 'promotionscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                } else {
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your update of the promotion has failed');
                    header('Location:' . URLROOT . 'promotionscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                }
            } else {
                // Handle the case where $post is not an array
                // You may want to log an error or display an error message
                Helper::log('error', 'Illegal string offset');
            }
        } else {
            $row = $this->promotionModel->getPromotionById($promotionId);
            $image = $this->screenModel->getScreenDataById($promotionId, 'promotion', 'main');
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
                'promotion' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image
            ];
            $this->view('promotions/update', $data);
        }
    }


    public function updateImage($promotionId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);
        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'promotion';
            $this->screenModel->insertScreenImages($screenId, $promotionId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'promotionscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'promotionscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if ($this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'promotionscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'promotionscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
        // Redirect to the overview page
    }

    public function delete($promotionId)
    {
        if ($this->promotionModel->deletePromotion($promotionId)) {
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Promotion deletion was successful.');
            header('Location: ' . URLROOT . 'promotionscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit();
        } else {
            // Log the error using Helper
            Helper::log('error', 'Promotion deletion failed.');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Promotion deletion failed.');
            header('Location:' . URLROOT . 'promotionscontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit;
        }
    }
}