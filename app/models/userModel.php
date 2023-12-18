<?php

class userModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function register($newCustomer)
    {


        global $var;

        try {
            $createCustomerQuery = "INSERT INTO `customers` (`customerId`, `customerType`, `customerFirstName`, `customerLastName`,
                                                             `customerEmail`, `customerPassword`,`customerPhone`, `customerAddress`, `customerZipCode`, `customerCreateDate`,
                                                             `customerIsActive`)
                                    VALUES (:customerId, 'customer', :customerFirstName, :customerLastName, :customerEmail, :customerPassword, null, null,
                                            null, :customerCreateDate, 1)";

            $this->db->query($createCustomerQuery);
            $this->db->bind(':customerId', $var['rand']);
            $this->db->bind(':customerFirstName', $newCustomer['customerFirstName']);
            $this->db->bind(':customerLastName', $newCustomer['customerLastName']);
            $this->db->bind(':customerEmail', $newCustomer['customerEmail']);
            $this->db->bind(':customerPassword', $newCustomer['customerPassword']);
            $this->db->bind(':customerCreateDate', $var['timestamp']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            helper::log('error', ' Failed to register Customer' . $ex->getMessage());
            return false;
        }
    }


    public function checkUserExist($email, $password)
    {
        try {
            $loginQuery = "SELECT `customerId`, `customerType`, `customerFirstName`, `customerLastName`, `customerEmail`,
                                  `customerPassword`, `customerPhone`, `customerAddress`, `customerZipCode`, `customerCreateDate`, `customerIsActive`
                           FROM `customers`
                           WHERE `customerEmail` = :customerEmail
                           AND `customerPassword` = :customerPassword";

            $this->db->query($loginQuery);
            $this->db->bind(":customerEmail", $email);
            $this->db->bind(":customerPassword", $password);

            // Return the result of the query
            return $this->db->single();
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to login customer' . $ex->getMessage());
            return false;
        }
    }

    public function editUser($post)
    {
        try {
            $updateCustomerQuery = 'UPDATE `customers` 
                               SET `customerType` = :customerType,
                                   `customerFirstName` = :customerFirstName,
                                   `customerLastName` = :customerLastName,
                                   `customerEmail` = :customerEmail,
                                   `customerPhone` = :customerPhone,
                                   `customerAddress` = :customerAddress,
                                   `customerZipCode` = :customerZipCode
                                WHERE `customerId` = :customerId';

            $this->db->query($updateCustomerQuery);
            $this->db->bind(':customerId', $post['customerId']);
            $this->db->bind(':customerType', $post['customerType']);
            $this->db->bind(':customerFirstName', $post['customerFirstName']);
            $this->db->bind(':customerLastName', $post['customerLastName']);
            $this->db->bind(':customerEmail', $post['customerEmail']);
            $this->db->bind(':customerPhone', $post['customerPhone']);
            $this->db->bind(':customerAddress', $post['customerAddress']);
            $this->db->bind(':customerZipCode', $post['customerZipCode']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            helper::log('error', ' Failed to update customer' . $ex->getMessage());
            return false;
        }
    }
}
