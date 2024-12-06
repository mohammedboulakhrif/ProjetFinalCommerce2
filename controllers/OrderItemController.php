<?php
require_once '../models/OrderItem.php';
require_once '../config/Database.php';

class OrderItemController {
    private $orderItemModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->orderItemModel = new OrderItem($db);
    }

  
    public function getOrderItems($order_id) {
        if ($order_id <= 0) {
            return []; 
        }

        return $this->orderItemModel->getOrderItems($order_id);
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'viewOrderItems') {
    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

    if ($order_id > 0) {
      
        $controller = new OrderItemController();
        $orderItems = $controller->getOrderItems($order_id);

        include '../views/orderDetails.php';
    } else {
    
        echo "<h3 style='color: red; text-align: center;'>Erreur : ID de commande invalide.</h3>";
    }
} else {
    echo "<h3 style='color: red; text-align: center;'>Erreur : Action non spécifiée ou invalide.</h3>";
}
?>
