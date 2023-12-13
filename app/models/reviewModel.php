<?php
class ReviewModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getActiveReviews()
    {
        try {
            $getActiveReviews = 'SELECT `reviewId`, `reviewCustomerId`, `reviewEntityId`, `reviewRating`, `reviewDescription`, `reviewCreateDate`, `reviewIsActive` FROM `reviews` WHERE reviewIsActive = 1';

            $this->db->query($getActiveReviews);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to get active reviews from the database in class ReviewModel.' . $ex->getMessage());
            return [];
        }
    }

    public function getReviewsByPagination($offset, $limit): array
    {
        try {
            $getReviewsByPaginationQuery =  'SELECT `reviewId`, `reviewCustomerId`, `reviewEntityId`, `reviewRating`, `reviewDescription`, `reviewCreateDate`, `reviewIsActive` FROM `reviews` WHERE reviewIsActive = 1
                                             LIMIT :offset,:limit';

            $this->db->query($getReviewsByPaginationQuery);
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            helper::log('error', ' Exception occurred while deleting ingredient' . $ex->getMessage());
            return [];
        }
    }

    public function getTotalReviewsCount()
    {
        try {
            $this->db->query("SELECT COUNT(*) as total FROM reviews where reviewIsActive = 1 ");
            $result = $this->db->single();

            return $result->total;
        } catch (PDOException $ex) {
            Helper::log('error', 'could not get total reviews' . $ex->getMessage());
        }
    }

    public function getReviewById($reviewId)
    {
        try {
            $getActiveReviews = 'SELECT `reviewId`, `reviewCustomerId`, `reviewEntityId`, `reviewRating`, `reviewDescription`, `reviewCreateDate`, `reviewIsActive` FROM `reviews` WHERE reviewId = :reviewId';

            $this->db->query($getActiveReviews);
            $this->db->bind(':reviewId', $reviewId);

            $result = $this->db->single();

            return $result ?? [];
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to get  reviews by Id from the database in class ReviewModel.' . $ex->getMessage());
            return [];
        }
    }

    public function createReview($newReview)
    {
        global $var;
        try {
            $createReviewQuery = 'INSERT INTO `reviews` (`reviewId`,`reviewCustomerId`, `reviewEntityId`, `reviewRating`, `reviewDescription`, `reviewCreateDate`, `reviewIsActive`)
                            VALUES (:reviewId, :reviewCustomerId, :reviewEntityId, :reviewRating, :reviewDescription, :reviewCreateDate, 1)';

            $this->db->query($createReviewQuery);
            $this->db->bind(':reviewId', $var['rand']);
            $this->db->bind(':reviewCustomerId', $newReview['reviewCustomerId']);
            $this->db->bind(':reviewEntityId', $newReview['reviewEntityId']);
            $this->db->bind(':reviewRating', $newReview['reviewRating']);
            $this->db->bind(':reviewDescription', $newReview['reviewDescription']);
            $this->db->bind(':reviewCreateDate', $var['timestamp']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to create review in ReviewModel' . $ex->getMessage());
            return false;
        }
    }

    public function updateReview($reviewId, $updatedReview)
    {
        try {
            $updateReviewQuery = 'UPDATE `reviews` 
                              SET `reviewCustomerId` = :reviewCustomerId, 
                                  `reviewEntityId` = :reviewEntityId, 
                                  `reviewRating` = :reviewRating, 
                                  `reviewDescription` = :reviewDescription 
                              WHERE `reviewId` = :reviewId';

            $this->db->query($updateReviewQuery);
            $this->db->bind(':reviewId', $reviewId);
            $this->db->bind(':reviewCustomerId', $updatedReview['reviewCustomerId']);
            $this->db->bind(':reviewEntityId', $updatedReview['reviewEntityId']);
            $this->db->bind(':reviewRating', $updatedReview['reviewRating']);
            $this->db->bind(':reviewDescription', $updatedReview['reviewDescription']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            Helper::log('error', 'Failed to update review in ReviewModel' . $ex->getMessage());
            return false;
        }
    }

    public function deleteReview($reviewId)
    {
        try {
            $deleteReviewQuery = "UPDATE `reviews` 
                    SET `reviewIsActive` = '0' 
                    WHERE `reviews`.`reviewId` = :reviewId";
            $this->db->query($deleteReviewQuery);
            $this->db->bind(':reviewId', $reviewId);
            return $this->db->execute();
        } catch (PDOException $ex) {
            Helper::log('error', 'could not set review to inactive...' . $ex->getMessage());
            return false;
        }
    }
}
