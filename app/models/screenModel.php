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

    public function createScreen($newScreen)
    {
        global $var;

        try {
            $createScreenQuery = 'INSERT INTO `screens` (`screenId`, `screenCreateDate`, `screenIsActive`, `screenEntityId`)
                            VALUES (:screenId, :screenCreateDate, 1, :screenEntityId)';

            $this->db->query($createScreenQuery);
            $this->db->bind(':screenId', $var['rand']);
            $this->db->bind(':screenCreateDate', $var['timestamp']);
            $this->db->bind(':screenEntityId', $newScreen['screenEntityId']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to create a screen in ScreenModel');
            throw $ex;
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
}
