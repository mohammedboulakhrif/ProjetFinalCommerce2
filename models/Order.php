<?php
require_once '../config/Database.php';

class Order {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createOrder($user_id, $name, $phone, $address, $city, $country, $zip, $total_amount) {
        $query = "INSERT INTO orders (user_id, name, phone, address, city, country, zip, total_amount) 
                  VALUES (:user_id, :name, :phone, :address, :city, :country, :zip, :total_amount)";
        
        $stmt = $this->conn->prepare($query);
    
       
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':zip', $zip);
        $stmt->bindParam(':total_amount', $total_amount);
    
        return $stmt->execute();
    }
    
    
   
    public function getUserOrders($user_id) {
        $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY placed_on DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getOrderTotal($order_id) {
        $query = $this->db->prepare("SELECT total_price FROM orders WHERE id = :order_id");
        $query->execute([':order_id' => $order_id]);
        return $query->fetch(PDO::FETCH_ASSOC)['total_price'] ?? 0;
    }


    public function getAllOrders() {
        $query = "SELECT o.id, o.user_id, o.name, o.phone, o.address, o.city, o.country, o.zip, o.status, o.placed_on,o.total_amount,
                         u.email AS user_name
                  FROM orders o
                  JOIN users u ON o.user_id = u.id
                  ORDER BY o.placed_on DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

     
    public function deleteOrder($order_id) {
        $query = "DELETE FROM orders WHERE id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    


    public function getOrderDetails($order_id) {
        $query = "SELECT id, total FROM orders WHERE id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function getOrderById($order_id)
    {
        $query = $this->db->prepare("SELECT * FROM orders WHERE id = :order_id");
        $query->execute([':order_id' => $order_id]);
    
        $order = $query->fetch(PDO::FETCH_ASSOC);
    
        
        if (!$order) {
            echo "Aucune commande trouvée pour l'ID : $order_id";
        }
    
        return $order;
    }


    public function getOrderTotalPrice($order_id)
    {
        $query = "SELECT SUM(price * quantity) AS total_price FROM order_items WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_price'];
    }
    
}
