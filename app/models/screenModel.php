<?php
class ScreenModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getActiveScreens()
    {
        try {
            $getActiveScreens = 'SELECT `screenId`, `screenCreateDate`, `screenIsActive`, `screenEntityId` FROM `screens` WHERE screenIsActive = 1';

            $this->db->query($getActiveScreens);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to get active screens from the database in class ReviewModel.');
            throw $ex; // Consider throwing the exception for better error handling.
        }
    }

    public function getScreenById($screenId)
    {
        try {
            $getScreenById = 'SELECT `screenId`, `screenCreateDate`, `screenIsActive`, `screenEntityId` FROM `screens` WHERE screenId = :screenId';

            $this->db->query($getScreenById);
            $this->db->bind(':screenId', $screenId);

            $result = $this->db->single();

            return $result ?? [];
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to get screen by Id from the database in class ReviewModel.');
            throw $ex; // Consider throwing the exception for better error handling.
        }
    }

    public function updateScreen($screenId, $updatedScreen)
    {
        try {
            $updateScreenQuery = "UPDATE `screens`
            SET `screenEntityId` = :screenEntityId
            WHERE `screenId` = :screenId";

            $this->db->query($updateScreenQuery);

            $this->db->bind(':screenId', $screenId);
            $this->db->bind(':screenEntityId', $updatedScreen['screenEntityId']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            Helper::log('error', 'Could not update the screen in the ScreenModel: ' . $ex->getMessage());
            exit;
        }
    }



    public function deleteScreen($screenId)
    {
        try {
            $updateScreenQuery = 'UPDATE `screens` SET `screenIsActive` = 0 WHERE `screenId` = :screenId';

            $this->db->query($updateScreenQuery);
            $this->db->bind(':screenId', $screenId);

            return $this->db->execute();
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to update screen in ScreenModel');
            throw $ex;
        }
    }

    public function insertScreenImages($screenId, $entityId, $entity, $scope = NULL)
    {
        global $var;
        // Check if a screen with the given entityId already exists
        $existingScreen = $this->getScreenByEntityId($entityId);
        if ($existingScreen) {
            // Update the existing screen to isActive = 0
            $this->updateScreenIsActive($existingScreen->screenId, 0);
        }
        // Insert the new screen
        $this->db->query("INSERT INTO screens (screenId,
                                               screenEntityId,
                                               screenEntity,
                                               screenScope,
                                               screenCreateDate,
                                               screenIsActive)
                           VALUES (:id, :screenEntityId, :screenEntity, :screenScope, :screenCreateDate, 1)");
        $this->db->bind(':id', $screenId);
        $this->db->bind(':screenEntityId', $entityId);
        $this->db->bind(':screenEntity', $entity);
        $this->db->bind(':screenScope', $scope);
        $this->db->bind(':screenCreateDate', $var['timestamp']);
        $this->db->execute();
    }

    public function updateScreenIsActive($screenId, $isActive)
    {
        $this->db->query("UPDATE screens SET screenIsActive = :isActive WHERE screenId = :screenId");
        $this->db->bind(':isActive', $isActive);
        $this->db->bind(':screenId', $screenId);
        $this->db->execute();
    }

    public function getScreenByEntityId($entityId)
    {
        $this->db->query("SELECT * FROM screens WHERE screenEntityId = :entityId");
        $this->db->bind(':entityId', $entityId);
        return $this->db->single();
    }

    public function getScreenDataById($entityId, $entity, $scope)
    {
        $this->db->query("SELECT screenId, screenEntity, screenCreateDate FROM screens WHERE screenEntityId = :screenEntityId AND screenEntity = :screenEntity AND screenScope = :screenScope AND screenIsActive = 1");
        $this->db->bind(':screenEntityId', $entityId);
        $this->db->bind(':screenEntity', $entity);
        $this->db->bind(':screenScope', $scope);
        return $this->db->single();
    }
}
