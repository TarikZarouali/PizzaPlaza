<?php

class OrderModel
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
            $getOrdersQuery = 'SELECT `orderId`, `orderCustomerId`, `orderStoreId`, `orderCreateDate`, `orderState`, `orderStatus`, `orderPrice`, `orderDescription` FROM `orders`';

            $this->db->query($getOrdersQuery);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to get active orders from the database in class OrderModel.' . $ex->getMessage());
            return [];
        }
    }

    public function getTotalOrdersCount()
    {
        try {
            $this->db->query("SELECT COUNT(*) as total FROM orders ");
            $result = $this->db->single();

            return $result->total;
        } catch (PDOException $ex) {
            helper::log('error', 'could not get total orders count' . $ex->getMessage());
            return false;
        }
    }

    public function getOrderById($orderId)
    {
        try {
            $getOrderByIdQuery = 'SELECT `orderId`, `orderCustomerId`, `orderStoreId`, `orderCreateDate`, `orderState`, `orderStatus`, `orderPrice`, `orderDescription` FROM `orders` WHERE orderId = :orderId';

            $this->db->query($getOrderByIdQuery);
            $this->db->bind(':orderId', $orderId);

            $result = $this->db->single();

            return $result;
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to get orders by Id from the database in class OrderModel.' . $ex->getMessage());
            return false;
        }
    }

    public function getOrdersByPagination($offset, $limit): array
    {
        try {
            $getOrdersByPaginationQuery =  'SELECT `orderId`, `orderCustomerId`, `orderStoreId`, `orderCreateDate`, `orderState`, `orderStatus`, `orderPrice`, `orderDescription` FROM `orders`
                                            LIMIT :offset,:limit';

            $this->db->query($getOrdersByPaginationQuery);
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            helper::log('error', ' Exception occurred while deleting ingredient' . $ex->getMessage());
            return [];
        }
    }

    public function createOrder($newOrder)
    {
        global $var;

        try {
            $createOrderQuery = 'INSERT INTO `orders` (`orderId`, `orderCustomerId`, `orderStoreId`, `orderCreateDate`, `orderState`, `orderStatus`, `orderPrice`, `orderDescription`) 
                                VALUES (:orderId, :orderCustomerId, :orderStoreId, :orderCreateDate, :orderState, :orderStatus, :orderPrice, :orderDescription)';

            $this->db->query($createOrderQuery);
            $this->db->bind(':orderId', $var['rand']);
            $this->db->bind(':orderCustomerId', $newOrder['orderCustomerId']);
            $this->db->bind(':orderStoreId', $newOrder['orderStoreId']);
            $this->db->bind(':orderCreateDate', $var['timestamp']);
            $this->db->bind(':orderState', $newOrder['orderState']);
            $this->db->bind(':orderStatus', $newOrder['orderStatus']);
            $this->db->bind(':orderPrice', $newOrder['orderPrice']);
            $this->db->bind(':orderDescription', $newOrder['orderDescription']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to create order in OrderModel' . $ex->getMessage());
            return false;
        }
    }

    public function updateOrder($orderId, $updatedOrder)
    {
        try {
            $updateOrderQuery = "UPDATE `orders` 
               SET `orderCustomerId` = :orderCustomerId,
                   `orderStoreId` = :orderStoreId,
                   `orderState` = :orderState,
                   `orderStatus`= :orderStatus,
                   `orderPrice` = :orderPrice,
                   `orderDescription` = :orderDescription   
                WHERE `orderId` = :orderId";

            $this->db->query($updateOrderQuery);

            $this->db->bind(':orderId', $orderId);
            $this->db->bind(':orderCustomerId', $updatedOrder['orderCustomerId']);
            $this->db->bind(':orderStoreId', $updatedOrder['orderStoreId']);
            $this->db->bind(':orderState', $updatedOrder['orderState']);
            $this->db->bind(':orderStatus', $updatedOrder['orderStatus']);
            $this->db->bind(':orderPrice', $updatedOrder['orderPrice']);
            $this->db->bind(':orderDescription', $updatedOrder['orderDescription']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            Helper::log('error', 'Could not update the order in the OrderModel: ' . $ex->getMessage());
            return false;
        }
    }


    public function deleteOrder($orderId)
    {
        try {
            $deleteOrderQuery = 'DELETE FROM `orders` WHERE `orderId` = :orderId';

            $this->db->query($deleteOrderQuery);
            $this->db->bind(':orderId', $orderId);

            return $this->db->execute();
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to delete order in OrderModel' . $ex->getMessage());
            return false;
        }
    }
}
