<?php

class productModel
{
    // Properties, fields
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getActiveProducts()
    {
        try {
            $getProductsQuery = "SELECT `productId`, `productOwner`, `productName`, `productDescription`, `productPrice`, `productType`, `productIsActive`, `productCreateDate` 
                                 FROM `products` 
                                 WHERE productIsActive = 1";

            $this->db->query($getProductsQuery);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            error_log("Error: Failed to get active products from the database in class storeModel.");
            die('Error: Failed to get active products');
        }
    }

    public function getProductById($productId)
    {
        try {
            $getProductByIdQuery = "SELECT `productId`, `productOwner`, `productName`, `productDescription`, `productPrice`, `productType`, `productIsActive`, `productCreateDate`
                                    FROM `products`
                                    WHERE `productId` = :productId";

            $this->db->query($getProductByIdQuery);
            $this->db->bind(':productId', $productId);

            $result = $this->db->single();

            return $result;
        } catch (PDOException $ex) {
            error_log("Error: Failed to get active products by Id from the database in class storeModel.");
            die('Error: Failed to get active products by Id');
        }
    }

    public function createProduct($newProduct)
    {
        global $var;

        try {
            $createProductQuery = "INSERT INTO `products` (`productId`, `productOwner`, `productName`, `productDescription`, `productPrice`, `productType`, `productIsActive`, `productCreateDate`) 
                            VALUES (:productId, null , :productName, :productDescription, :productPrice, :productType, 1, :productCreateDate)";

            $this->db->query($createProductQuery);
            $this->db->bind(':productId', $var['rand']);
            $this->db->bind(':productName', $newProduct['productName']);
            $this->db->bind(':productDescription', $newProduct['productDescription']);
            $this->db->bind(':productPrice', $newProduct['productPrice']);
            $this->db->bind(':productType', $newProduct['productType']);
            $this->db->bind(':productCreateDate', $var['timestamp']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            error_log("ERROR: Failed to create Product");
            die("ERROR: Failed to create Product");
        }
    }

    public function updateProduct($productId, $updatedProduct)
    {
        $response = ["success" => false, "message" => "Product not found"];

        try {
            $updateProductQuery = "UPDATE `products` 
                    SET `productName` = :productName,
                        `productDescription` = :productDescription,
                        `productPrice` = :productPrice,
                        `productType` = :productType,
                        `productIsActive` = 1
                    WHERE `productId` = :productId";

            $this->db->query($updateProductQuery);

            $this->db->bind(':productId', $productId);
            $this->db->bind(':productName', $updatedProduct['productName']);
            $this->db->bind(':productDescription', $updatedProduct['productDescription']);
            $this->db->bind(':productPrice', $updatedProduct['productPrice']);
            $this->db->bind(':productType', $updatedProduct['productType']);

            if ($this->db->execute()) {
                $response["success"] = true;
                $response["message"] = "Product updated successfully";
            }
        } catch (PDOException $ex) {
            error_log("Error: Failed to update product - " . $ex->getMessage());
        }

        return $response;
    }




    public function deleteProduct($productId)
    {
        try {
            $deleteProductQuery = "UPDATE `products` 
                                SET `productIsActive` = '0' 
                                WHERE `products`.`productId` = :productId";
            $this->db->query($deleteProductQuery);
            $this->db->bind(':productId', $productId);

            // Execute the query
            if ($this->db->execute()) {
                error_log("INFO: Product has been deleted");
                return true;
            } else {
                error_log("ERROR: Product could not be deleted");
                return false;
            }
        } catch (PDOException $ex) {
            error_log("ERROR: Exception occurred while deleting product: " . $ex->getMessage());
            return false;
        }
    }
}