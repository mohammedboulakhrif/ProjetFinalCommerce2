<?php
class Product {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addProduct($name, $description, $image, $prix, $category) {
        $query = "INSERT INTO products (name, description, image, prix, category) VALUES (:name, :description, :image, :prix, :category)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':category', $category);
        return $stmt->execute();
    }

    public function getAllProducts() {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteProduct($id) {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateProduct($id, $name, $description, $image, $prix, $category) {
        $query = "UPDATE products SET name = :name, description = :description, image = :image, prix = :prix, category = :category WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':category', $category);
        return $stmt->execute();
    }

    public function getFilteredProducts($category = '', $price_min = '', $price_max = '') {
        $query = "SELECT * FROM products WHERE 1=1";

        if (!empty($category)) {
            $query .= " AND category = :category";
        }
        if (!empty($price_min)) {
            $query .= " AND prix >= :price_min";
        }
        if (!empty($price_max)) {
            $query .= " AND prix <= :price_max";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($category)) {
            $stmt->bindParam(':category', $category);
        }
        if (!empty($price_min)) {
            $stmt->bindParam(':price_min', $price_min);
        }
        if (!empty($price_max)) {
            $stmt->bindParam(':price_max', $price_max);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
