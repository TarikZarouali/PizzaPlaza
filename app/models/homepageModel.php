<?php

class homepageModel
{
    // Properties, fields
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getProductsByFilter($filters = [], $offset = NULL, $limit = NULL)
    {
        $query = "SELECT DISTINCT p.productId,
                              p.productName,
                              p.productPrice,
                              p.productType 
                              FROM products as p
                              WHERE p.productIsActive = 1";

        // Add conditions based on the provided filters
        if (isset($filters['type'])) {
            $query .= " AND p.productType = :type";
        }

        if (isset($filters['ingredients'])) {
            $ingredientPlaceholders = implode(',', array_map(function ($index) {
                return ":ingredient{$index}";
            }, array_keys($filters['ingredients'])));

            $query .= " AND p.productId IN (SELECT DISTINCT phi.productId FROM producthasingredients as phi WHERE phi.ingredientId IN ({$ingredientPlaceholders}))";
        }

        if (isset($filters['rating'])) {
            $query .= " AND p.productId IN (SELECT DISTINCT r.reviewEntityId FROM reviews as r WHERE r.reviewRating >= :rating)";
        }

        if (isset($filters['search'])) {
            $query .= " AND p.productName LIKE :search";
        }

        if (isset($filters['pricemax'])) {
            $filters['pricemin'] = $filters['pricemin'] ?? 0;
            $query .= " AND p.productPrice BETWEEN :pricemin AND :pricemax";
        }

        if (isset($offset) && isset($limit) && !empty($limit)) {
            $query .= " LIMIT :offset, :limit";
        }

        // Execute the query and bind parameters
        $this->db->query($query);

        if (isset($offset) && isset($limit) && !empty($limit)) {
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);
        }

        foreach ($filters as $key => $value) {
            if ($key === 'ingredients') {
                foreach ($value as $index => $ingredientId) {
                    $this->db->bind(":ingredient{$index}", $ingredientId);
                }
            } elseif ($key === 'search') {
                // Handle search
                $this->db->bind(':search', '%' . $value . '%');
            } elseif ($key !== 'page') {
                $this->db->bind(":$key", $value);
            }
        }

        return $this->db->resultSet();
    }

    public function searchProduct($searchTerm)
    {
        try {
            $getProductsBySearchingQuery = "SELECT `productId`, `productOwner`, `productName`, `productDescription`, `productPrice`, `productType`, `productIsActive`, `productCreateDate` 
                                        FROM `products` 
                                        WHERE productName 
                                        LIKE :searchTerm";
            $this->db->query($getProductsBySearchingQuery);
            $this->db->bind(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);

            // Execute the query after binding
            $this->db->execute();

            $result = $this->db->resultSet();

            return $result;
        } catch (PDOException $ex) {
            helper::log('error', 'Error searching for products: ' . $ex->getMessage());
            return false;
        }
    }

    public function sortProductByPrice($sortOption)
    {
        try {
            switch ($sortOption) {
                case 'price-asc':
                    $sortDirection = 'ASC';
                    break;
                case 'price-desc':
                    $sortDirection = 'DESC';
                    break;
                default:
                    $sortDirection = 'ASC'; // Default to ascending order if no valid option is provided
                    break;
            }

            $sortProductByPriceQuery = "SELECT `productId`, `productOwner`, `productName`, `productDescription`, `productPrice`, `productType`, `productIsActive`, `productCreateDate` 
                                    FROM `products`
                                    ORDER BY productPrice $sortDirection";
            $this->db->query($sortProductByPriceQuery);
            $result = $this->db->resultSet();

            return $result;
        } catch (PDOException $ex) {
            helper::log('error', 'Could not sort by price on the sortProductByPrice function in the productmodel' . $ex->getMessage());
            return false;
        }
    }

    public function register($newCustomer)
    {


        global $var;

        try {
            $createCustomerQuery = "INSERT INTO `customers` (`customerId`, `customerType`, `customerFirstName`, `customerLastName`, `customerEmail`, `customerPassword`,`customerPhone`, `customerAddress`, `customerZipCode`, `customerCreateDate`, `customerIsActive`) 
                                    VALUES (:customerId, 'customer', :customerFirstName, :customerLastName, :customerEmail, :customerPassword, null, null, null, :customerCreateDate, 1)";

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
            $loginQuery = "SELECT `customerId`, `customerType`, `customerFirstName`, `customerLastName`, `customerEmail`, `customerPhone`, `customerAddress`, `customerZipCode`, `customerCreateDate`, `customerIsActive`
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
}