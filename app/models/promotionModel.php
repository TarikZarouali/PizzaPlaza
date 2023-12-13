<?php

class promotionModel
{
    // Properties, fields
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    public function getActivePromotions()
    {
        try {
            $getPromotionsQuery = "SELECT `promotionId`, `promotionName`, `promotionDescription`, `promotionIsActive`, `promotionCreateDate`, `promotionEndDate` FROM `promotions` WHERE promotionIsActive = 1";

            $this->db->query($getPromotionsQuery);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            helper::log('Error', 'Failed to get active promotions from the database in class storeModel.' . $ex->getMessage());
            return [];
        }
    }

    public function getTotalPromotionsCount()
    {
        try {
            $this->db->query("SELECT COUNT(*) as total FROM promotions where promotionIsActive = 1 ");
            $result = $this->db->single();

            return $result->total;
        } catch (PDOException $ex) {
            helper::log('error', 'could not get total promotions' . $ex->getMessage());
            return false;
        }
    }

    public function getPromotionByPagination($offset, $limit): array
    {
        try {
            $getPromotionsByPaginationQuery = "SELECT `promotionId`, `promotionName`, `promotionDescription`, `promotionIsActive`, `promotionCreateDate`, `promotionEndDate` FROM `promotions` WHERE promotionIsActive = 1
                                               LIMIT :offset,:limit";

            $this->db->query($getPromotionsByPaginationQuery);
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            helper::log('error', 'Exception occurred while deleting ingredient' . $ex->getMessage());
            return [];
        }
    }

    public function createPromotion($newPromotion)
    {
        global $var;
        try {
            // Convert the date to a UNIX timestamp
            $promotionEndDate = strtotime($newPromotion['promotionEndDate']);

            $createPromotionQuery = "INSERT INTO `promotions` (`promotionId`, `promotionName`, `promotionDescription`, `promotionIsActive`, `promotionCreateDate`, `promotionEndDate`) 
                    VALUES (:promotionId, :promotionName, :promotionDescription, 1, :promotionCreateDate, :promotionEndDate)";

            $this->db->query($createPromotionQuery);
            $this->db->bind(':promotionId', $var['rand']);
            $this->db->bind(':promotionName', $newPromotion['promotionName']);
            $this->db->bind(':promotionDescription', $newPromotion['promotionDescription']);
            $this->db->bind(':promotionCreateDate', $var['timestamp']);
            $this->db->bind(':promotionEndDate', $promotionEndDate);

            $this->db->execute();
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to create a new promotion in the database in class storeModel.' . $ex->getMessage());
            return false;
        }
    }

    public function deletepromotion($promotionId)
    {
        try {
            $deletepromotionQuery = "UPDATE `promotions` 
                                SET `promotionIsActive` = '0' 
                                WHERE `promotions`.`promotionId` = :promotionId";
            $this->db->query($deletepromotionQuery);
            $this->db->bind(':promotionId', $promotionId);

            // Execute the query
            if ($this->db->execute()) {
                helper::log('info', 'Promotion has been deleted');
                return true;
            } else {
                helper::log('error', 'Promotion could not be deleted');
                return false;
            }
        } catch (PDOException $ex) {
            helper::log('error', 'Exception occurred while deleting Promotion: ' . $ex->getMessage());
            return false;
        }
    }

    public function getPromotionById($promotionId)
    {
        try {
            $getPromotionsByIdQuery = "SELECT `promotionId`, `promotionName`, `promotionDescription`, `promotionIsActive`, `promotionCreateDate`, `promotionEndDate`
                                    FROM `promotions`
                                    WHERE `promotionId` = :promotionId";

            $this->db->query($getPromotionsByIdQuery);
            $this->db->bind(':promotionId', $promotionId);

            $result = $this->db->single();

            return $result;
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to get active promotions by Id from the database in class storeModel.' . $ex->getMessage());
            return false;
        }
    }

    public function updatePromotion($promotionId, $updatedPromotion)
    {
        $response = ["success" => false, "message" => "Promotion not found"];

        try {
            if (isset($updatedPromotion['promotionEndDate'])) {
                $updatePromotionQuery = "UPDATE `promotions` 
                SET `promotionName` = :promotionName,
                    `promotionDescription` = :promotionDescription,
                    `promotionEndDate` = :promotionEndDate
                WHERE `promotionId` = :promotionId";

                $this->db->query($updatePromotionQuery);
                $this->db->bind(':promotionId', $promotionId);
                $this->db->bind(':promotionName', $updatedPromotion['promotionName']);
                $this->db->bind(':promotionDescription', $updatedPromotion['promotionDescription']);
                $this->db->bind(':promotionEndDate', $updatedPromotion['promotionEndDate']);

                if ($this->db->execute()) {
                    $response["success"] = true;
                    $response["message"] = "Promotion updated successfully";
                }
            }
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to update promotion' . $ex->getMessage());
            return false;
        }

        return $response;
    }
}
