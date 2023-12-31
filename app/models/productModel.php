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
            $getProductsQuery = 'SELECT `productId`, `productOwner`, `productName`, `productDescription`, `productPrice`, `productType`, `productIsActive`, `productCreateDate` 
                                 FROM `products` 
                                 WHERE `productIsActive` = 1';

            $this->db->query($getProductsQuery);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            helper::log('error', ' Failed to get active products from the database in class storeModel.' . $ex->getMessage());
            return [];
        }
    }

    public function getTotalProductsCount()
    {
        try {
            $this->db->query('SELECT COUNT(*) as total FROM products where productIsActive = 1 ');
            $result = $this->db->single();

            return $result->total;
        } catch (PDOException $ex) {
            helper::log('error', 'could not get total products' . $ex->getMessage());
            return false;
        }
    }



    public function getProductById($productId)
    {
        try {
            $getProductByIdQuery = 'SELECT `productId`, `productOwner`, `productName`, `productDescription`, `productPrice`, `productType`, `productIsActive`, `productCreateDate`
                                    FROM `products`
                                    WHERE `productId` = :productId';

            $this->db->query($getProductByIdQuery);
            $this->db->bind(':productId', $productId);

            $result = $this->db->single();

            return $result;
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to get active products by Id from the database in class storeModel.' . $ex->getMessage());
            return false;
        }
    }

    public function getProductsByPagination($offset, $limit): array
    {
        try {
            $getProductsByPaginationQuery =  'SELECT `productId`, `productOwner`, `productName`, `productDescription`, `productPrice`, `productType`, `productIsActive`, `productCreateDate`
                                              FROM `products` WHERE productIsActive = 1
                                              LIMIT :offset,:limit';

            $this->db->query($getProductsByPaginationQuery);
            $this->db->bind(':offset', $offset);
            $this->db->bind(':limit', $limit);

            $result = $this->db->resultSet();

            return $result ?? [];
        } catch (PDOException $ex) {
            helper::log('error', 'Exception occurred while deleting ingredient:' . $ex->getMessage());
            return [];
        }
    }

    public function createProduct($newProduct)
    {
        global $var;

        try {
            $createProductQuery = 'INSERT INTO `products` (`productId`, `productOwner`, `productName`, `productDescription`, `productPrice`, `productType`, `productIsActive`, `productCreateDate`) 
                            VALUES (:productId, :productOwner , :productName, :productDescription, :productPrice, :productType, 1, :productCreateDate)';

            $this->db->query($createProductQuery);
            $this->db->bind(':productId', $var['rand']);
            $this->db->bind(':productOwner', $newProduct['productOwner']);
            $this->db->bind(':productName', $newProduct['productName']);
            $this->db->bind(':productDescription', $newProduct['productDescription']);
            $this->db->bind(':productPrice', $newProduct['productPrice']);
            $this->db->bind(':productType', $newProduct['productType']);
            $this->db->bind(':productCreateDate', $var['timestamp']);

            return $this->db->execute();
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to create Product' . $ex->getMessage());
            return false;
        }
    }

    public function updateProduct($productId, $updatedProduct)
    {
        $response = ['success' => false, 'message' => 'Product not found'];

        try {
            $updateProductQuery = 'UPDATE `products` 
                    SET `productName` = :productName,
                        `productDescription` = :productDescription,
                        `productPrice` = :productPrice,
                        `productType` = :productType,
                        `productIsActive` = 1
                    WHERE `productId` = :productId';

            $this->db->query($updateProductQuery);

            $this->db->bind(':productId', $productId);
            $this->db->bind(':productName', $updatedProduct['productName']);
            $this->db->bind(':productDescription', $updatedProduct['productDescription']);
            $this->db->bind(':productPrice', $updatedProduct['productPrice']);
            $this->db->bind(':productType', $updatedProduct['productType']);

            if ($this->db->execute()) {
                $response['success'] = true;
                $response['message'] = 'Product updated successfully';
            }
        } catch (PDOException $ex) {
            helper::log('error', 'Failed to update product - ' . $ex->getMessage());
            return false;
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
                helper::log('info', 'product has been deleted');
                return true;
            } else {
                helper::log('error', 'product could not be deleted');
                return false;
            }
        } catch (PDOException $ex) {
            helper::log('error', 'exception occurred while deleting product: ' . $ex->getMessage());
            return false;
        }
    }
}
