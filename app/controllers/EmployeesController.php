<?php
class EmployeesController extends Controller
{

    private $employeeModel;
    private $storeModel;

    public function __construct()
    {
        $this->employeeModel = $this->model('employeeModel');
        $this->storeModel = $this->model('storeModel');
    }

    public function overview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getActiveEmployees = $this->employeeModel->getActiveEmployees();
            $data = [
                'Employees' => $getActiveEmployees
            ];

            $this->view('employees/overview', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validate and process the form data, and insert a new employee into the database
            $createEmployee = $this->employeeModel->createEmployee($post);

            if ($createEmployee) {
                header('Location: ' . URLROOT . '/employeesController/overview/');
                exit();
            } else {
                Helper::log('error', 'Employee creation failed');
                header('Location: ' . URLROOT . '/employeesController/overview/');
                exit();
            }
        } else {
            // Display the form for creating a new employee with the list of active stores
            $getActiveStores = $this->storeModel->getActiveStores(); // Retrieve active stores
            $data = [
                'Stores' => $getActiveStores,
            ];

            $this->view('employees/create', $data); // Use 'create' view to render the form
        }
    }

    public function update($employeeId)
    {
        $selectedEmployee = $this->employeeModel->getEmployeeById($employeeId);
        $activeStores = $this->storeModel->getActiveStores();

        if (!$selectedEmployee) {
            Helper::log('error', 'Employee Id was not found.');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the employee using the retrieved POST data
            $updated = $this->employeeModel->updateEmployee($employeeId, $post);

            if ($updated) {
                // employee updated successfully, redirect to the employee overview page
                header('Location: ' . URLROOT . 'employeescontroller/overview/');
                exit;
            } else {
                Helper::log('error', 'Employee update failed');
                header('Location:' . URLROOT . 'employeescontroller/update/' . $employeeId);
                exit;
            }
        }
        // Load the update view with the selected employee data
        $data = [
            'Employee' => $selectedEmployee,
            'Stores' => $activeStores
        ];
        $this->view('employees/update', $data);
    }

    public function delete($employeeId)
    {
        if ($this->employeeModel->deleteEmployee($employeeId)) {
            header('Location:' . URLROOT . 'employeescontroller/overview');
        } else {
            Helper::log('error', 'Employee delete failed');
            header('Location:' . URLROOT . 'employeescontroller/overview/');
            exit;
        }
    }
}