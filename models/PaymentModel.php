<?php
class PaymentModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getOrderTotalPrice($order_id) {
        $query = "SELECT total_price FROM orders WHERE id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':order_id' => $order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        return $order['total_price'];
    }
}
?>
