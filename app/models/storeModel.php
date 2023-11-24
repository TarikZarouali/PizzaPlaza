<?php

class storeModel
{
    // Properties, fields
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getActiveStores(): array
    {
        try {
            $getStoresQuery = "SELECT `storeId`, `storeStreetName`, `storeCity`, `storePhone`, `storeZipCode`, `storeEmail`, `storeManager`, `storeIsActive`, `storeCreateDate` FROM `stores` WHERE storeIsActive= 1";

            $this->db->query($getStoresQuery);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            error_log("Error: Failed to get active stores from the database in class storeModel.");
            die('Error: Failed to get active stores');
        }
    }

    public function getTotalStoresCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM stores WHERE storeIsActive = 1");
        $result = $this->db->single();

        return $result->total;
    }
    public function getStoresByPagination($offset, $limit): array
    {
        try {
            $getStoresByPaginationQuery =  'SELECT `storeId`, `storeStreetName`, `storeCity`, `storePhone`, `storeZipCode`, `storeEmail`, `storeManager`, `storeIsActive`, `storeCreateDate` FROM `stores` WHERE storeIsActive= 1
                                             LIMIT :offset,:limit';

            $this->db->query($getStoresByPaginationQuery);
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            error_log('error', ' Exception occurred while deleting ingredient: '());
            return false;
        }
    }

    public function getStoreById($storeId)
    {
        try {
            $selectedStore = "SELECT `storeId`, `storeStreetName`, `storeCity`, `storePhone`, `storeZipCode`, `storeEmail`, `storeManager`, `storeIsActive`, `storeCreateDate` FROM `stores` WHERE `storeIsActive` = 1 AND `storeId` = :storeId";

            $this->db->query($selectedStore);
            $this->db->bind(':storeId', $storeId);

            $result = $this->db->single();

            return $result;
        } catch (PDOException $ex) {
            error_log("ERROR: Failed to retrieve store by ID");
            die("ERROR: Failed to retrieve store by ID");
        }
    }

    public function createStore($newStore)
    {
        global $var;

        try {
            $createStoreQuery = "INSERT INTO `stores` (`storeId`, `storeStreetName`, `storeCity`, `storePhone`, `storeZipCode`, `storeEmail`, `storeManager`, `storeIsActive`, `storeCreateDate`) 
                                VALUES (:storeId, :storeStreetName, :storeCity, :storePhone, :storeZipCode, :storeEmail, null , 1, :storeCreateDate)";

            $this->db->query($createStoreQuery);
            $this->db->bind(':storeId', $var['rand']);
            $this->db->bind(':storeStreetName', $newStore['storeStreetName']);
            $this->db->bind(':storeCity', $newStore['storeCity']);
            $this->db->bind(':storePhone', $newStore['storePhone']);
            $this->db->bind(':storeZipCode', $newStore['storeZipCode']);
            $this->db->bind(':storeEmail', $newStore['storeEmail']);
            $this->db->bind(':storeCreateDate', $var['timestamp']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            error_log("ERROR: Failed to create store");
            die("ERROR: Failed to create store");
        }
    }

    public function updateStore($storeId, $updatedStore)
    {
        $response = ["success" => false, "message" => "Store not found"];

        try {
            $updateStoreQuery = "UPDATE `stores` 
                           SET `storeStreetName` = :storeStreetName,
                               `storeCity` = :storeCity,
                               `storePhone` = :storePhone,
                               `storeZipCode` = :storeZipCode,
                               `storeEmail` = :storeEmail,
                               `storeManager` = null,
                               `storeIsActive` = 1
                            WHERE `storeId` = :storeId";

            $this->db->query($updateStoreQuery);

            $this->db->bind(':storeId', $storeId);
            $this->db->bind(':storeStreetName', $updatedStore['storeStreetName']);
            $this->db->bind(':storeCity', $updatedStore['storeCity']);
            $this->db->bind(':storePhone', $updatedStore['storePhone']);
            $this->db->bind(':storeZipCode', $updatedStore['storeZipCode']);
            $this->db->bind(':storeEmail', $updatedStore['storeEmail']);

            if ($this->db->execute()) {
                $response["success"] = true;
                $response["message"] = "Store updated successfully";
            }
        } catch (PDOException $ex) {
            error_log("Error: Failed to update store - " . $ex->getMessage());
        }

        return $response;
    }

    public function deleteStore($storeId)
    {
        try {
            $deleteStoreQuery = "UPDATE `stores` 
                        SET `storeIsActive` = '0' 
                        WHERE `stores`.`storeId` = :storeId";
            $this->db->query($deleteStoreQuery);
            $this->db->bind(':storeId', $storeId);

            // Execute the query
            if ($this->db->execute()) {
                error_log("INFO: Store has been marked as inactive");
                return true;
            } else {
                error_log("ERROR: Store could not be marked as inactive");
                return false;
            }
        } catch (PDOException $ex) {
            error_log("ERROR: Exception occurred while marking the store as inactive: " . $ex->getMessage());
            return false;
        }
    }
}
