<?php

class Vehicles extends Controller
{
    private $vehicleModel;
    private $storeModel;
    private $screenModel;

    public function __construct()
    {
        $this->vehicleModel = $this->model('vehicleModel');
        $this->screenModel = $this->model('screenModel');
        $this->storeModel = $this->model('storeModel');
    }

    public function overview($pageNumber = 1)
    {
        $pageNumber = isset($params['page']) ? intval($params['page']) : 1;

        // Set the number of records per page
        $recordsPerPage = 2;

        $offset = ($pageNumber - 1) * $recordsPerPage;

        // Get the total number of ingredients
        $vehicles = $this->vehicleModel->getVehiclesByPagination($offset, $recordsPerPage);

        $countVehicles = $this->vehicleModel->getTotalVehiclesCount();

        $totalPages = ceil($countVehicles / $recordsPerPage);

        $pageNumber = max(min($pageNumber, $totalPages), 1);

        $totalPages = ceil($countVehicles / $recordsPerPage);

        $pageNumber = max(1, min($pageNumber, $totalPages));

        // Pass data to the view
        $data = [
            'vehicles' => $vehicles,
            'countVehicles' => $countVehicles,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];

        $this->view('vehicles/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validate and process the form data, and insert a new vehicle into the database
            $createVehicle = $this->vehicleModel->createVehicle($post);

            if ($createVehicle) {
                // Redirect on success with a success message
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Vehicle creation successful');
                header('Location:' . URLROOT . 'vehicles/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Vehicle could not be created');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Vehicle creation failed. Please try again.');
                header('Location:' . URLROOT . 'vehicles/create/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            }
        } else {
            // Display the form for creating a new vehicle with the list of active stores
            $activeStores = $this->storeModel->getActiveStores(); // Retrieve active stores
            $data = [
                'Stores' => $activeStores,
            ];

            $this->view('vehicles/create', $data);
        }
    }

    public function update($params)
    {
        $vehicleId = $params['vehicleId'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if $post is an array before proceeding
            if (is_array($post)) {
                $result = $this->vehicleModel->updateVehicle($vehicleId, $post);

                // Check the success key in the result
                if ($result['success']) {
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Your update of the vehicle was successful');
                    header('Location:' . URLROOT . 'vehicles/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                } else {
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your update of the vehicle has failed');
                    header('Location:' . URLROOT . 'vehicles/update/' . $vehicleId . '/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                }
            } else {
                // Handle the case where $post is not an array
                // You may want to log an error or display an error message
                Helper::log('error', 'Illegal string offset');
            }
        } else {
            $row = $this->vehicleModel->getVehicleById($vehicleId);
            $image = $this->screenModel->getScreenDataById($vehicleId, 'vehicle', 'main');
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
            $activeStores = $this->storeModel->getActiveStores();
            $data = [
                'vehicle' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image,
                'Store' => $activeStores
            ];
            $this->view('vehicles/update', $data);
        }
    }


    public function updateImage($params)
    {
        $vehicleId = $params['vehicleId'];
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);
        if ($imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false) {
            $entity = 'vehicle';
            $this->screenModel->insertScreenImages($screenId, $vehicleId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . '/vehicles/update/{vehicleId:' . $vehicleId . ';' . $toast . ';' . $toasttitle . ';' . $toastmessage . '}');
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . '/vehicles/update/{vehicleId:' . $vehicleId . ';' . $toast . ';' . $toasttitle . ';' . $toastmessage . '}');
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
            header('Location:' . URLROOT . 'vehicles/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'vehicles/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
        }
        // Redirect to the overview page
    }

    public function delete($params)
    {
        $vehicleId = $params['vehicleId'];
        if ($this->vehicleModel->deleteVehicle($vehicleId)) {
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Store deletion was successful.');
            header('Location:' . URLROOT . 'vehicles/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit();
        } else {
            // Log the error using Helper
            Helper::log('error', 'Store could not be deleted');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Store deletion failed.');
            header('Location:' . URLROOT . 'vehicles/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit();
        }
    }
}