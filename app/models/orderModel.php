<?php

class orderModel
{
    // Properties, fields
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getActiveOrders()
    {
        try {
            $getOrdersQuery = "SELECT `orderId`, `orderCustomerId`, `orderStoreId`, `orderCreateDate`, `orderState`, `orderStatus`, `orderPrice`, `orderDescription` FROM `orders`";

            $this->db->query($getOrdersQuery);


            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            error_log("Error: Failed to get active orders from the database in class storeModel.");
            die('Error: Failed to get active orders');
        }
    }
}