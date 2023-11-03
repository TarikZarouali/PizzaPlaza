<?php

class ingredientModel
{
    // Properties, fields
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getActiveIngredients()
    {
        try {
            $getIngredientsQuery = "SELECT `ingredientId`, `ingredientName`, `ingredientIsActive`, `ingredientDescription`, `ingredientCreateDate`, `ingredientPrice` FROM `ingredients` WHERE ingredientIsActive = 1";

            $this->db->query($getIngredientsQuery);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            error_log("Error: Failed to get active Ingredients from the database in class storeModel.");
            die('Error: Failed to get active Ingredients');
        }
    }

    public function deleteIngredient($ingredientId)
    {
        try {
            $deleteIngredient = "UPDATE `ingredients` 
                                SET `ingredientIsActive` = '0' 
                                WHERE `ingredients`.`ingredientId` = :ingredientId";
            $this->db->query($deleteIngredient);
            $this->db->bind(':ingredientId', $ingredientId);

            // Execute the query
            if ($this->db->execute()) {
                error_log("INFO: ingredient has been deleted");
                return true;
            } else {
                error_log("ERROR: ingredient could not be deleted");
                return false;
            }
        } catch (PDOException $ex) {
            error_log("ERROR: Exception occurred while deleting ingredient: " . $ex->getMessage());
            return false;
        }
    }

    public function createIngredient($newIngredient)
    {
        global $var;

        try {
            $createIngredient = "INSERT INTO `ingredients` (`ingredientId`, `ingredientName`, `ingredientIsActive`, `ingredientDescription`,`ingredientCreateDate`,`ingredientPrice`) 
                            VALUES (:ingredientId, :ingredientName, 1, :ingredientDescription, :ingredientCreateDate, :ingredientPrice)";

            $this->db->query($createIngredient);
            $this->db->bind(':ingredientId', $var['rand']);
            $this->db->bind(':ingredientName', $newIngredient['ingredientName']);
            $this->db->bind(':ingredientDescription', $newIngredient['ingredientDescription']);
            $this->db->bind(':ingredientCreateDate', $var['timestamp']);
            $this->db->bind(':ingredientPrice', $newIngredient['ingredientPrice']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            error_log("ERROR: Failed to create Ingredient");
            die("ERROR: Failed to create Ingredient");
        }
    }

    public function getIngredientById($ingredientId)
    {
        try {
            $getIngredientByIdQuery = "SELECT `ingredientId`, `ingredientName`, `ingredientIsActive`, `ingredientDescription`, `ingredientCreateDate`, `ingredientPrice`
                                    FROM `ingredients`
                                    WHERE `ingredientId` = :ingredientId";

            $this->db->query($getIngredientByIdQuery);
            $this->db->bind(':ingredientId', $ingredientId);

            $result = $this->db->single();

            return $result;
        } catch (PDOException $ex) {
            error_log("Error: Failed to get active Ingredients by Id from the database in class storeModel.");
            die('Error: Failed to get active products by Id');
        }
    }

    public function updateIngredient($ingredientId, $updatedIngredient)
    {
        $response = ["success" => false, "message" => "Product not found"];

        try {
            $updateIngredientQuery = "UPDATE `ingredients` 
                    SET `ingredientName` = :ingredientName,
                        `ingredientIsActive` = 1,
                        `ingredientDescription` = :ingredientDescription,
                        `ingredientPrice` = :ingredientPrice
                    WHERE `ingredientId` = :ingredientId";

            $this->db->query($updateIngredientQuery);

            $this->db->bind(':ingredientId', $ingredientId);
            $this->db->bind(':ingredientName', $updatedIngredient['ingredientName']);
            $this->db->bind(':ingredientDescription', $updatedIngredient['ingredientDescription']);
            $this->db->bind(':ingredientPrice', $updatedIngredient['ingredientPrice']);

            if ($this->db->execute()) {
                $response["success"] = true;
                $response["message"] = "Ingredient updated successfully";
            }
        } catch (PDOException $ex) {
            error_log("Error: Failed to update Ingredient - " . $ex->getMessage());
        }

        return $response;
    }
}
