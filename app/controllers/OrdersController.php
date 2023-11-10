<?php
class OrdersController extends Controller
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

    public function overview()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $getOrders = $this->orderModel->getActiveOrders();
            $data = [
                'Orders' => $getOrders
            ];

            $this->view('orders/overview', $data);
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validate and process the form data, and insert a new vehicle into the database
            $createOrder = $this->orderModel->createOrder($post);

            if ($createOrder) {
                header('Location: ' . URLROOT . '/orderscontroller/overview');
                exit();
            } else {
                // If vehicle creation failed, you can handle it here
                Helper::log('error', 'Order could not be created.');
                header('Location: ' . URLROOT . '/orderscontroller/overview/');
                exit();
            }
        } else {
            // Display the form for creating a new vehicle with the list of active stores
            $activeStores = $this->storeModel->getActiveStores(); // Retrieve active stores
            $activeCustomers = $this->customerModel->getActiveCustomers();
            $data = [
                'Stores' => $activeStores,
                'Customers' => $activeCustomers
            ];

            $this->view('orders/create', $data);
        }
    }

    public function update($orderId)
    {
        $selectedOrder = $this->orderModel->getOrderById($orderId);
        $storeByOrderId = $this->storeModel->getActiveStores();
        $customerByStoreId = $this->customerModel->getActiveCustomers();

        if (!$selectedOrder) {
            Helper::log('error', 'Order ID could not be found.');
            header('Location:' . URLROOT . 'orderscontroller/overview/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Filter and validate your POST data properly
            $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            // Update the order using the retrieved POST data
            $updated = $this->orderModel->updateOrder($orderId, $post);

            if ($updated) {
                // Order updated successfully, redirect to the order overview page
                header('Location: ' . URLROOT . 'orderscontroller/overview/');
            } else {
                Helper::log('error', 'Order update failed.');
                header('Location:' . URLROOT . 'orderscontroller/update/' . $orderId);
            }
            exit; // Move the exit statement here
        }

        // Load the update view with the selected order data
        $data = [
            'Orders' => $selectedOrder,
            'Stores' => $storeByOrderId,
            'Customers' => $customerByStoreId
        ];
        $this->view('orders/update', $data);
    }


    public function delete($orderId)
    {
        if ($this->orderModel->deleteOrder($orderId)) {
            header('Location:' . URLROOT . 'orderscontroller/overview');
        } else {
            Helper::log('error', 'vehicle deletion failed.');
            header('Location:' . URLROOT . 'orderscontroller/overview/');
            exit;
        }
    }
}
