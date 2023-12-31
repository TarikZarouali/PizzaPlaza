<?php

class vehicleModel
{
    // Properties, fields
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function getActiveVehicles()
    {
        try {
            $getVehicleQuery = "SELECT `vehicleId`, `vehicleStoreId`, `vehicleMaintenanceDate`, `vehicleType`, `vehicleIsActive`, `vehicleCreateDate` FROM `vehicles` WHERE vehicleIsActive = 1";

            $this->db->query($getVehicleQuery);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to get active vehicles from the database in class vehicleModel.' . $ex->getMessage());
            return [];
        }
    }

    public function getTotalVehiclesCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM vehicles WHERE vehicleIsActive = 1");
        $result = $this->db->single();

        return $result->total;
    }

    public function getVehiclesByPagination($offset, $limit): array
    {
        try {
            $getVehiclesByPaginationQuery = 'SELECT `vehicleId`, `vehicleStoreId`, `vehicleMaintenanceDate`, `vehicleType`, `vehicleIsActive`, `vehicleCreateDate` FROM `vehicles` WHERE vehicleIsActive = 1
                                               LIMIT :offset,:limit';

            $this->db->query($getVehiclesByPaginationQuery);
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            helper::log('error', ' Exception occurred while deleting ingredient' . $ex->getMessage());
            return [];
        }
    }

    public function getVehicleById($vehicleId)
    {
        try {
            $selectedVehicle = "SELECT `vehicleId`, `vehicleStoreId`, `vehicleMaintenanceDate`, `vehicleType`, `vehicleIsActive`, `vehicleCreateDate` FROM `vehicles` WHERE `vehicleIsActive` = 1 AND `vehicleId` = :vehicleId";

            $this->db->query($selectedVehicle);
            $this->db->bind(':vehicleId', $vehicleId);

            $result = $this->db->single();

            return $result;
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to retrieve vehicle by ID' . $ex->getMessage());
            return false;
        }
    }

    public function createVehicle($newVehicle)
    {
        global $var;

        try {
            $createVehicle = "INSERT INTO `vehicles` (`vehicleId`, `vehicleStoreId`, `vehicleMaintenanceDate`, `vehicleType`, `vehicleIsActive`, `vehicleCreateDate`) 
                                VALUES (:vehicleId, :vehicleStoreId, :vehicleMaintenanceDate, :vehicleType, 1, :vehicleCreateDate)";

            $this->db->query($createVehicle);
            $this->db->bind(':vehicleId', $var['rand']);
            $this->db->bind(':vehicleStoreId', $newVehicle['vehicleStoreId']);
            $this->db->bind(':vehicleMaintenanceDate', $newVehicle['vehicleMaintenanceDate']);
            $this->db->bind(':vehicleType', $newVehicle['vehicleType']);
            $this->db->bind(':vehicleCreateDate', $var['timestamp']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to create Vehicle' . $ex->getMessage());
            return false;
        }
    }

    public function updateVehicle($vehicleId, $updatedVehicle)
    {
        $response = ["success" => false, "message" => "Vehicle not found"];

        try {
            $updateVehicleQuery = "UPDATE `vehicles` 
                       SET `vehicleStoreId` = :vehicleStoreId,
                           `vehicleMaintenanceDate` = :vehicleMaintenanceDate,
                           `vehicleType` = :vehicleType,
                           `vehicleIsActive` = 1
                        WHERE `vehicleId` = :vehicleId";

            $this->db->query($updateVehicleQuery);

            $this->db->bind(':vehicleId', $vehicleId);
            $this->db->bind(':vehicleStoreId', $updatedVehicle['vehicleStoreId']);
            $this->db->bind(':vehicleMaintenanceDate', $updatedVehicle['vehicleMaintenanceDate']);
            $this->db->bind(':vehicleType', $updatedVehicle['vehicleType']);

            if ($this->db->execute()) {
                $response["success"] = true;
                $response["message"] = "Vehicle updated successfully";
            }
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to update Vehicle' . $ex->getMessage());
            return false;
        }

        return $response;
    }


    public function deleteVehicle($vehicleId)
    {
        try {
            $deleteVehicleQuery = "UPDATE `vehicles` 
                        SET `vehicleIsActive` = '0' 
                        WHERE `vehicles`.`vehicleId` = :vehicleId";
            $this->db->query($deleteVehicleQuery);
            $this->db->bind(':vehicleId', $vehicleId);

            // Execute the query
            if ($this->db->execute()) {
                helper::log('info', 'vehicle has been marked as inactive');
                return true;
            } else {
                helper::log('error', 'vehicle could not be marked as inactive');
                return false;
            }
        } catch (PDOException $ex) {
            helper::log('error', 'Exception occurred while marking the vehicle as inactive' . $ex->getMessage());
            return false;
        }
    }
}
