<?php
class Orders extends Controller
{
    private $orderModel;
    private $storeModel;
    private $customerModel;

    public function __construct()
    {
        $this->orderModel = $this->model('orderModel');
        $this->storeModel = $this->model('storeModel');
        $this->customerModel = $this->model('customerModel');
    }


    public function overview($params)
    {
        $pageNumber = isset($params['page']) ? intval($params['page']) : 1;

        // Set the number of records per page
        $recordsPerPage = 2;

        $offset = ($pageNumber - 1) * $recordsPerPage;

        // Get the total number of ingredients
        $orders = $this->orderModel->getOrdersByPagination($offset, $recordsPerPage);

        $countOrders = $this->orderModel->getTotalOrdersCount();

        $totalPages = ceil($countOrders / $recordsPerPage);

        $pageNumber = max(min($pageNumber, $totalPages), 1);

        $totalPages = ceil($countOrders / $recordsPerPage);

        $pageNumber = max(1, min($pageNumber, $totalPages));

        // Pass data to the view
        $data = [
            'orders' => $orders,
            'countOrders' => $countOrders,
            'currentPage' => $pageNumber,
            'recordsPerPage' => $recordsPerPage,
            'totalPages' => $totalPages,
        ];

        $this->view('orders/overview', $data);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validate and process the form data, and insert a new order into the database
            $createOrder = $this->orderModel->createOrder($post);

            if ($createOrder) {
                // Redirect on success with a success message
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Order creation was successful');
                header('Location:' . URLROOT . 'orders/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            } else {
                // Log the error using Helper
                Helper::log('error', 'Order could not be created');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Order creation failed. Please try again');
                header('Location:' . URLROOT . 'orders/create/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit();
            }
        } else {
            // Display the form for creating a new order with the list of active stores and customers
            $activeStores = $this->storeModel->getActiveStores(); // Retrieve active stores
            $activeCustomers = $this->customerModel->getActiveCustomers();
            $data = [
                'Stores' => $activeStores,
                'Customers' => $activeCustomers
            ];

            $this->view('orders/create', $data);
        }
    }

    public function update($params)
    {
        $orderId = $params['orderId'];
        $selectedOrder = $this->orderModel->getOrderById($orderId);
        $storeByOrderId = $this->storeModel->getActiveStores();
        $customerByStoreId = $this->customerModel->getActiveCustomers();

        if (!$selectedOrder) {
            // Handle the case where the order is not found
            Helper::log('error', 'Order ID could not be found');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Order ID could not be found');
            header('Location:' . URLROOT . 'orders/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Update the order using the retrieved POST data
            $updated = $this->orderModel->updateOrder($orderId, $post);

            if ($updated) {
                // Redirect on success with a success message
                $toast = urlencode('true');
                $toasttitle = urlencode('Success');
                $toastmessage = urlencode('Order update was successful');
                header('Location:' . URLROOT . 'orders/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit;
            } else {
                // Log the error using Helper
                Helper::log('error', 'Order update failed');
                // Redirect on failure with an error message
                $toast = urlencode('false');
                $toasttitle = urlencode('Failed');
                $toastmessage = urlencode('Order update failed');
                header('Location:' . URLROOT . 'orders/overview/' . $orderId . '/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
                exit;
            }
        }

        // Load the update view with the selected order data
        $data = [
            'Orders' => $selectedOrder,
            'Stores' => $storeByOrderId,
            'Customers' => $customerByStoreId
        ];
        $this->view('orders/update', $data);
    }

    public function delete($params)
    {
        $orderId = $params['orderId'];

        if ($this->orderModel->deleteOrder($orderId)) {
            // Redirect on success with a success message
            $toast = urlencode('true');
            $toasttitle = urlencode('Success');
            $toastmessage = urlencode('Order deletion was successful');
            header('Location:' . URLROOT . 'orders/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit;
        } else {
            // Log the error using Helper
            Helper::log('error', 'Order deletion failed.');
            // Redirect on failure with an error message
            $toast = urlencode('false');
            $toasttitle = urlencode('Failed');
            $toastmessage = urlencode('Order deletion failed');
            header('Location:' . URLROOT . 'orders/overview/{' . $toast . ':' . $toasttitle . ';' . $toastmessage . '}');
            exit;
        }
    }
}
