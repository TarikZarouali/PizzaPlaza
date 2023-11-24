<?php

class Employees extends Controller
{

    private $employeeModel;
    private $storeModel;
    private $screenModel;

    public function __construct()
    {
        $this->employeeModel = $this->model('employeeModel');
        $this->screenModel = $this->model('screenModel');
        $this->storeModel = $this->model('storeModel');
    }


    public function overview($params)
    {

        $pageNumber = isset($params['page']) ? intval($params['page']) : 1;

        // Set the number of records per page
        $recordsPerPage = 2;

        $offset = ($pageNumber - 1) * $recordsPerPage;

        // Get the total number of ingredients
        $employees = $this->employeeModel->getEmployeesByPagination($offset, $recordsPerPage);

        $countEmployees = $this->employeeModel->getTotalEmployeesCount();

        $totalPages = ceil($countEmployees / $recordsPerPage);

        $pageNumber = max(min($pageNumber, $totalPages), 1);

        $totalPages = ceil($countEmployees / $recordsPerPage);

        $pageNumber = max(1, min($pageNumber, $totalPages));

        // Pass data to the view
        $data = [
            'employees' => $employees,
            'countEmployees' => $countEmployees,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];

        $this->view('employees/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validate and process the form data, and insert a new employee into the database
            $createEmployee = $this->employeeModel->createEmployee($post);

            if ($createEmployee) {
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Employee creation successful');
                header('Location:' . URLROOT . 'employees/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            } else {
                Helper::log('error', 'Employee creation failed');
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Employee creation failed. Please try again');
                header('Location:' . URLROOT . 'employees/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            }
        } else {
            // Display the form for creating a new employee with the list of active stores
            $getActiveStores = $this->storeModel->getActiveStores(); // Retrieve active stores
            $data = [
                'Stores' => $getActiveStores,
            ];

            $this->view('employees/create', $data);
        }
    }

    public function update($params)
    {
        $employeeId = $params['employeeId'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Check if $post is an array before proceeding
            if (is_array($post)) {
                $result = $this->employeeModel->updateEmployee($employeeId, $post);

                // Check the success key in the result
                if ($result['success']) {
                    $toast = urlencode('true');
                    $toasttitle = urlencode('Success');
                    $toastmessage = urlencode('Your update of the employee was successful');
                    header('Location:' . URLROOT . 'employees/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                } else {
                    $toast = urlencode('false');
                    $toasttitle = urlencode('Failed');
                    $toastmessage = urlencode('Your update of the employee has failed');
                    header('Location:' . URLROOT . 'employees/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                }
            } else {
                // Handle the case where $post is not an array
                // You may want to log an error or display an error message
                Helper::log('error', 'Illegal string offset');
            }
        } else {
            $row = $this->employeeModel->getEmployeeById($employeeId);
            $image = $this->screenModel->getScreenDataById($employeeId, 'employee', 'main');
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
                'Employee' => $row,
                'imageSrc' => $imageSrc,
                'image' => $image,
                'Store' => $activeStores
            ];
            $this->view('employees/update', $data);
        }
    }


    public function updateImage($params)
    {
        $employeeId = $params['employeeId'];
        global $var;
        $screenId = $var['rand'];
        $imageUploaderResult = $this->imageUploader($screenId);
        if (
            $imageUploaderResult['status'] === 200 && strpos($imageUploaderResult['message'], 'Image uploaded successfully') !== false
        ) {
            $entity = 'employee';
            $this->screenModel->insertScreenImages($screenId, $employeeId, $entity, 'main');
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Your create of the image was successful');
            header('Location:' . URLROOT . '/employees/update/{employeeId:' . $employeeId . ';' . $toast . ';' . $toasttitle . ';' . $toastmessage . '}');
        } else {
            Helper::log('error', $imageUploaderResult);
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Your create of the image has failed');
            header('Location:' . URLROOT . '/employees/update/{employeeId:' . $employeeId . ';' . $toast . ';' . $toasttitle . ';' . $toastmessage . '}');
        }
    }

    public function deleteImage($params)
    {

        $screenId = $params['screenId'];
        $customer = $params['customerId'];
        // Call the deleteScreen method from the model
        if ($this->screenModel->deleteScreen($screenId)) {
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Image deleted successfully');
            header('Location:' . URLROOT . 'employees/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
        } else {
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Image deleted Failed');
            header('Location:' . URLROOT . 'employees/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
        }
        // Redirect to the overview page
    }

    public function delete($params)
    {


        $employeeId = $params['employeeId'];
        if ($this->employeeModel->deleteEmployee($employeeId)) {
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Employee deletion was successful');
            header('Location:' . URLROOT . 'employees/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit;
        } else {
            Helper::log('error', 'Employee delete failed');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Employee deletion has failed');
            header('Location:' . URLROOT . 'employees/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit;
        }
    }
}
