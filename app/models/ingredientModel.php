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
            helper::log('error', 'Failed to get active Ingredients from the database in class storeModel.' . $ex->getMessage());
            return [];
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
            helper::log('error', ' Failed to get active Ingredients by Id from the database in class storeModel.' . $ex->getMessage());
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
            helper::log('error', 'Failed to create Ingredient' . $ex->getMessage());
            return false;
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
            helper::log('error', 'Failed to update Ingredient' . $ex->getMessage());
            return false;
        }

        return $response;
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
                helper::log('info', 'ingredient has been deleted');
                return true;
            } else {
                helper::log('error', 'ingredient could not be deleted');
                return false;
            }
        } catch (PDOException $ex) {
            helper::log('error', 'Exception occurred while deleting ingredient: ' . $ex->getMessage());
            return false;
        }
    }

    public function getIngredientsByPagination($offset, $limit): array
    {
        try {
            $getIngredientsByPaginationQuery = "SELECT ingredientId, ingredientName, ingredientDescription, ingredientCreateDate, ingredientPrice 
                                                FROM ingredients
                                                WHERE ingredientIsActive = 1 LIMIT :offset,:limit";

            $this->db->query($getIngredientsByPaginationQuery);
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            helper::log('error', ' Exception occurred while deleting ingredient:' . $ex->getMessage());
            return [];
        }
    }

    public function getTotalIngredientsCount()
    {
        try {
            $this->db->query("SELECT COUNT(*) as total FROM ingredients WHERE ingredientIsActive = 1");
            $result = $this->db->single();

            return $result->total;
        } catch (PDOException $ex) {
            helper::log('error', 'could not get ingredients count' . $ex->getMessage());
            return false;
        }
    }
}
