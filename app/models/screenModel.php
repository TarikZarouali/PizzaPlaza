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
            $getActiveScreens = 'SELECT `screenId`, `screenCreateDate`, `screenIsActive`, `screenEntityId`, `screenEntity`, `screenScope` FROM `screens` WHERE screenIsActive = 1';

            $this->db->query($getActiveScreens);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to get active screens from the database in class ReviewModel.' . $ex->getMessage());
            return [];
        }
    }

    public function getScreensByPagination($offset, $limit): array
    {
        try {
            $getScreensByPaginationQuery =  'SELECT `screenId`, `screenCreateDate`, `screenIsActive`, `screenEntityId` FROM `screens` WHERE screenIsActive = 1
                                              LIMIT :offset,:limit';

            $this->db->query($getScreensByPaginationQuery);
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            helper::log('error', ' Exception occurred while deleting ingredient' . $ex->getMessage());
            return [];
        }
    }

    public function getScreenImage($entityId)
    {
        $screenData = $this->getScreenByEntityId($entityId);

        if ($screenData) {
            $screenId = $screenData->screenId;
            $screenCreateDate = date('Ymd', $screenData->screenCreateDate);

            $imagePath = IMAGEROOT . $screenCreateDate . '/' . $screenId . '.jpg'; // Adjust the file extension as needed

            return $imagePath;
        } else {
            helper::log('error', 'no image found');
            return null;
        }
    }

    public function getTotalScreensCount()
    {
        try {
            $this->db->query("SELECT COUNT(*) as total FROM screens where screenIsActive = 1 ");
            $result = $this->db->single();

            return $result->total;
        } catch (PDOException $ex) {
            helper::log('error', 'could not get total screens' . $ex->getmessage());
            return false;
        }
    }

    public function getScreenById($screenId)
    {
        try {
            $getScreenById = 'SELECT `screenId`, `screenCreateDate`, `screenIsActive`, `screenEntityId` FROM `screens` WHERE screenId = :screenId';

            $this->db->query($getScreenById);
            $this->db->bind(':screenId', $screenId);

            $result = $this->db->single();

            return $result;
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to get screen by Id from the database in class ReviewModel.' . $ex->getMessage());
            return false;
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
            return false;
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
                           VALUES (:screenId, :screenEntityId, :screenEntity, :screenScope, :screenCreateDate, 1)");
        $this->db->bind(':screenId', $screenId);
        $this->db->bind(':screenEntityId', $entityId);
        $this->db->bind(':screenEntity', $entity);
        $this->db->bind(':screenScope', $scope);
        $this->db->bind(':screenCreateDate', $var['timestamp']);
        $this->db->execute();
    }

    public function updateScreenIsActive($screenId, $isActive)
    {
        try {
            $this->db->query("UPDATE screens SET screenIsActive = :isActive WHERE screenId = :screenId");
            $this->db->bind(':isActive', $isActive);
            $this->db->bind(':screenId', $screenId);
            $this->db->execute();
        } catch (PDOException $ex) {
            helper::log('error', 'problem with screen' . $ex->getMessage());
            return false;
        }
    }

    public function getScreenByEntityId($entityId)
    {
        try {
            $this->db->query("SELECT * FROM screens WHERE screenEntityId = :entityId");
            $this->db->bind(':entityId', $entityId);
            return $this->db->single();
        } catch (PDOException $ex) {
            helper::log('error', 'problem with screen entity by Id' . $ex->getMessage());
            return false;
        }
    }

    public function getScreenDataById($entityId, $entity, $scope)
    {
        try {
            $this->db->query("SELECT screenId, screenEntity, screenCreateDate FROM screens WHERE screenEntityId = :screenEntityId AND screenEntity = :screenEntity AND screenScope = :screenScope AND screenIsActive = 1");
            $this->db->bind(':screenEntityId', $entityId);
            $this->db->bind(':screenEntity', $entity);
            $this->db->bind(':screenScope', $scope);
            return $this->db->single();
        } catch (PDOException $ex) {
            helper::log('error', 'problem with screen data by Id' . $ex->getMessage());
            return false;
        }
    }

    public function insertMultipleScreenImages($screenId, $entityId, $entity, $newScope)
    {
        try {
            global $var;
            // Use the provided entityId as the screenEntityId
            $this->db->query("INSERT INTO screens (screenId,
                                       screenEntityId,
                                       screenEntity,
                                       screenScope,
                                       screenCreateDate,
                                       screenIsActive)
                   VALUES (:screenId, :screenEntityId, :screenEntity, :screenScope, :screenCreateDate, 1)");
            $this->db->bind(':screenId', $screenId);
            $this->db->bind(':screenEntityId', $entityId); // Use entityId here
            $this->db->bind(':screenEntity', $entity);
            $this->db->bind(':screenScope', $newScope);
            $this->db->bind(':screenCreateDate', $var['timestamp']);
            $this->db->execute();
        } catch (PDOException $ex) {
            helper::log('error', 'problem with screen insert multiple images' . $ex->getMessage());
            return false;
        }
    }


    public function getMultipleScreensByEntityId($entityId, $scope = null)
    {
        try {
            if ($scope !== null) {
                $this->db->query("SELECT screenId, screenCreateDate, screenIsActive, screenEntityId, screenEntity, screenScope FROM screens WHERE screenEntityId = :entityId AND screenScope = :scope AND screenIsActive = 1");
                $this->db->bind(':scope', $scope);
            } else {
                $this->db->query("SELECT  screenId, screenCreateDate, screenIsActive, screenEntityId, screenEntity, screenScope FROM screens WHERE screenEntityId = :entityId AND screenIsActive = 1");
            }

            $this->db->bind(':entityId', $entityId);
            return $this->db->resultSet();
        } catch (PDOException $ex) {
            helper::log('error', 'problem with screen multiple screens getting' . $ex->getMessage());
            return [];
        }
    }
}
