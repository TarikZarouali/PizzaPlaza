<?php

class employeeModel
{
    // Properties, fields
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getActiveEmployees()
    {
        try {
            $getEmployeesQuery = "SELECT `employeeId`, `employeeStoreId`, `employeeFirstName`, `employeeLastName`, `employeeZipCode`, `employeeRole`, `employeeIsActive`, `employeeCreateDate`, `employeeDescription` FROM `employees` WHERE employeeIsActive = 1";

            $this->db->query($getEmployeesQuery);


            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            error_log("Error: Failed to get active employees from the database in class storeModel.");
            die('Error: Failed to get active employees');
        }
    }

    public function getTotalEmployeesCount()
    {
        $this->db->query("SELECT COUNT(*) as total FROM employees WHERE employeeIsActive = 1");
        $result = $this->db->single();

        return $result->total;
    }

    public function getEmployeeById($employeeId)
    {
        try {
            $getEmployeeById = "SELECT `employeeId`, `employeeStoreId`, `employeeFirstName`, `employeeLastName`, `employeeZipCode`, `employeeRole`, `employeeIsActive`, `employeeCreateDate`, `employeeDescription` FROM `employees` WHERE `employeeId` = :employeeId";

            $this->db->query($getEmployeeById);

            $this->db->bind(':employeeId', $employeeId);

            $result = $this->db->single();

            return $result ?? null;
        } catch (PDOException $ex) {
            error_log("Error: Failed to get Employee by ID from the database");
            die('Error: Failed to get Employee by ID');
        }
    }

    public function getEmployeesByPagination($offset, $limit): array
    {
        try {
            $getEmployeeByPagination = "SELECT `employeeId`, `employeeStoreId`, `employeeFirstName`, `employeeLastName`, `employeeZipCode`, `employeeRole`, `employeeIsActive`, `employeeCreateDate`, `employeeDescription` FROM `employees`
                                              WHERE `employeeIsActive` = 1 LIMIT :offset, :limit";

            $this->db->query($getEmployeeByPagination);
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            error_log('error', ' Exception occurred while getting employee: '());
            return false;
        }
    }

    public function createEmployee($newEmployee)
    {
        global $var;

        try {
            $createEmployee = "INSERT INTO `employees` (`employeeId`, `employeeStoreId`, `employeeFirstName`, `employeeLastName`, `employeeZipCode`, `employeeRole`, `employeeIsActive`, `employeeCreateDate`, `employeeDescription`) 
                                VALUES (:employeeId, :employeeStoreId, :employeeFirstName, :employeeLastName, :employeeZipCode, :employeeRole, 1, :employeeCreateDate, :employeeDescription)";

            $this->db->query($createEmployee);
            $this->db->bind(':employeeId', $var['rand']);
            $this->db->bind(':employeeStoreId', $newEmployee['employeeStoreId']);
            $this->db->bind(':employeeFirstName', $newEmployee['employeeFirstName']);
            $this->db->bind(':employeeLastName', $newEmployee['employeeLastName']);
            $this->db->bind(':employeeZipCode', $newEmployee['employeeZipCode']);
            $this->db->bind(':employeeRole', $newEmployee['employeeRole']);
            $this->db->bind(':employeeCreateDate', $var['timestamp']);
            $this->db->bind(':employeeDescription', $newEmployee['employeeDescription']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            error_log("ERROR: Failed to create Employee");
            die("ERROR: Failed to create Employee");
        }
    }

    public function updateEmployee($employeeId, $updatedEmployee)
    {
        $response = ["success" => false, "message" => "Vehicle not found"];

        try {
            $updateEmployeeId = "UPDATE `employees` 
                       SET `employeeStoreId` = :employeeStoreId,
                           `employeeFirstName` = :employeeFirstName,
                           `employeeLastName` = :employeeLastName,
                           `employeeZipCode` = :employeeZipCode,
                           `employeeRole` = :employeeRole,
                           `employeeDescription` = :employeeDescription
                        WHERE `employeeId` = :employeeId";

            $this->db->query($updateEmployeeId);

            $this->db->bind(':employeeId', $employeeId);
            $this->db->bind(':employeeStoreId', $updatedEmployee['employeeStoreId']);
            $this->db->bind(':employeeFirstName', $updatedEmployee['employeeFirstName']);
            $this->db->bind(':employeeLastName', $updatedEmployee['employeeLastName']);
            $this->db->bind(':employeeZipCode', $updatedEmployee['employeeZipCode']);
            $this->db->bind(':employeeRole', $updatedEmployee['employeeRole']);
            $this->db->bind(':employeeDescription', $updatedEmployee['employeeDescription']);


            if ($this->db->execute()) {
                $response["success"] = true;
                $response["message"] = "Vehicle updated successfully";
            }
        } catch (PDOException $ex) {
            error_log("Error: Failed to update Vehicle - " . $ex->getMessage());
        }

        return $response;
    }

    public function deleteEmployee($employeeId)
    {
        try {
            $deleteEmployeeQuery = "UPDATE `employees` 
                        SET `employeeIsActive` = '0' 
                        WHERE `employees`.`employeeId` = :employeeId";
            $this->db->query($deleteEmployeeQuery);
            $this->db->bind(':employeeId', $employeeId);

            // Execute the query
            if ($this->db->execute()) {
                error_log("INFO: employeeId has been marked as inactive");
                return true;
            } else {
                error_log("ERROR: employeeId could not be marked as inactive");
                return false;
            }
        } catch (PDOException $ex) {
            error_log("ERROR: Exception occurred while marking the employeeId as inactive: " . $ex->getMessage());
            return false;
        }
    }
}
