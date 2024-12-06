<?php


require_once '../models/Order.php';
require_once '../models/OrderItem.php';
require_once '../models/Cart.php';
require_once '../config/Database.php';

class OrderController
{
    private $orderModel;
    private $orderItemModel;
    private $cartModel;
    private $db;

    public function __construct()
    {
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->orderModel = new Order($this->db);
        $this->orderItemModel = new OrderItem($this->db);
        $this->cartModel = new Cart($this->db);
    }


    public function redirect($url)
    {
        header("Location: $url");
        exit();
    }

   
    public function placeOrder()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            $this->redirect("login.php");
        }  
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         
            $user_id = $_SESSION['user']['id'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $zip = $_POST['zip'];
    
           
            $cartItems = $this->cartModel->getCartItems($user_id);
            $total_amount = 0;
    
            foreach ($cartItems as $item) {
                $total_amount += $item['product_price'] * $item['quantity'];  
            }
    
            if ($this->orderModel->createOrder($user_id, $name, $phone, $address, $city, $country, $zip, $total_amount)) {
               
                $order_id = $this->db->lastInsertId();
    
                $this->addOrderItems($order_id, $user_id);
    
                
                $_SESSION['order_id'] = $order_id;
                $_SESSION['total_price'] = $total_amount;  
    
                
                $this->cartModel->clearCart($user_id);
    
               
                $this->redirect("../views/paymentView.php");
            } else {
                echo "Erreur lors de la création de la commande.";
            }
        }
    }
    
    



    private function addOrderItems($order_id, $user_id)
    {
       
        $cartItems = $this->cartModel->getCartItems($user_id);
        foreach ($cartItems as $item) {
            $this->orderItemModel->addOrderItem(
                $order_id,
                $item['product_id'],
                $item['product_name'],
                $item['product_image'],
                $item['quantity'],
                $item['product_price']
            );
        }
    }

    public function deleteOrder()
    {
        if (isset($_GET['id'])) {
            $order_id = $_GET['id'];

            if ($this->orderModel->deleteOrder($order_id)) {
                $_SESSION['message'] = "Commande supprimée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression de la commande.";
            }

            $this->redirect('../views/adminVue.php');
        }
    }

    public function viewOrders()
    {
        return $this->orderModel->getAllOrders();
    }
}


$orderController = new OrderController();

//cette partie est responsable juste sur le routage
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'placeOrder':
        $orderController->placeOrder();
        break;

    case 'delete':
        $orderController->deleteOrder();
        break;

    default:
        
        $orders = $orderController->viewOrders();
        break;
}
?>
