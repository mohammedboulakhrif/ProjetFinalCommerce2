<?php
class OrderItem {
    private $conn;
    private $table = "order_items";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addOrderItem($order_id, $product_id, $product_name, $product_image, $quantity, $price) {
        $query = "INSERT INTO order_items (order_id, product_id, product_name, product_image, quantity, price)
                  VALUES (:order_id, :product_id, :product_name, :product_image, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':product_image', $product_image);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
    
        return $stmt->execute();
    }
    
    
   
    public function getOrderItems($order_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
