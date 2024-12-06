<?php
require_once '../config/Database.php';

class Cart {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function addToCart($user_id, $product_id, $product_name, $product_description, $product_image, $product_price, $product_category, $quantity) {
        $query = "
            INSERT INTO cart (user_id, product_id, product_name, product_description, product_image, product_price, product_category, quantity) 
            VALUES (:user_id, :product_id, :product_name, :product_description, :product_image, :product_price, :product_category, :quantity)
            ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_description', $product_description);
        $stmt->bindParam(':product_image', $product_image);
        $stmt->bindParam(':product_price', $product_price);
        $stmt->bindParam(':product_category', $product_category);
        $stmt->bindParam(':quantity', $quantity);
    
        return $stmt->execute();
    }
    
    public function clearCart($user_id) {
        $query = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        return $stmt->execute();
    }
    

    
    public function getCartItems($user_id) {
        $query = "SELECT * FROM cart WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateQuantity($cart_id, $quantity) {
        $query = "UPDATE cart SET quantity = :quantity WHERE id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id);
        $stmt->bindParam(':quantity', $quantity);
        return $stmt->execute();
    }
    
    
    public function removeFromCart($cart_id) {
        $query = "DELETE FROM cart WHERE id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id);
        return $stmt->execute();
    }
    
}
