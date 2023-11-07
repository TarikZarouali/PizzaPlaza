<?php
class OrdersController extends Controller
{

    private $orderModel;

    public function __construct()
    {
        $this->orderModel = $this->model('orderModel');
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
}
