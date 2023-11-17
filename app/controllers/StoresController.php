<?php
class StoresController extends Controller
{

    private $storeModel;
    private $screenModel;

    public function __construct()
    {
        $this->screenModel = $this->model('screenModel');
        $this->storeModel = $this->model('storeModel');
    }

    public function overview()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getStores = $this->storeModel->getActiveStores();
            $data = [
                'Stores' => $getStores
            ];

            $this->view('stores/overview', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle the form submission
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $createStore = $this->storeModel->createStore($post);

            if ($createStore) {
                // Redirect on success with a success message
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Store creation successful.');
                header('Location: ' . URLROOT . 'storescontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Store could not be created');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Store creation failed. Please try again.');
                header('Location: ' . URLROOT . 'storescontroller/create/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                exit();
            }
        } else {
            // Display the form
            $this->view('stores/create');
        }
    }

    public function delete($storeId)
    {
        if ($this->storeModel->deleteStore($storeId)) {
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Store deletion was successful.');
            header('Location: ' . URLROOT . 'storescontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit();
        } else {
            // Log the error using Helper
            Helper::log('error', 'Store could not be deleted');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Store deletion failed.');
            header('Location:' . URLROOT . 'storescontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
            exit();
        }
    }

    public function update($storeId = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if $post is an array before proceeding
            if (is_array($post)) {
                $result = $this->storeModel->updateStore($storeId, $post);

                // Check the success key in the result
                if ($result['success']) {
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Your update of the store was successful');
                    header('Location:' . URLROOT . 'storescontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                } else {
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your update of the store has failed');
                    header('Location:' . URLROOT . 'storescontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
                }
            } else {
                // Handle the case where $post is not an array
                // You may want to log an error or display an error message
                Helper::log('error', 'Illegal string offset');
            }
        } else {
            $row = $this->storeModel->getStoreById($storeId);
            $image = $this->screenModel->getScreenDataById($storeId, 'store', 'main');
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
                'Store' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image
            ];
            $this->view('stores/update', $data);
        }
    }


    public function updateImage($storeId)
    {
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);
        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'store';
            $this->screenModel->insertScreenImages($screenId, $storeId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . 'storescontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . 'storescontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
    }

    public function deleteImage($screenId)
    {
        // Call the deleteScreen method from the model
        if ($this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'storescontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'storescontroller/overview/' . $toast . '/' . $toasttitle . '/' . $toastmessage);
        }
        // Redirect to the overview page
    }
}
