<?php

require_once '../models/Cart.php';
require_once '../config/Database.php';

class CartController
{
    private $cartModel;

    public function __construct($db)
    {
       
        $this->cartModel = new Cart($db);
    }

    public function getCartItems($user_id)
    {
        
        return $this->cartModel->getCartItems($user_id);
    }

    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['product_id']) && isset($_SESSION['user']['id'])) {
                $user_id = $_SESSION['user']['id'];
                $product_id = $data['product_id'];
                $product_name = $data['product_name'];
                $product_description = $data['product_description'];
                $product_image = $data['product_image'];
                $product_price = $data['product_price'];
                $product_category = $data['product_category'];
                $quantity = $data['quantity'] ?? 1;

                $result = $this->cartModel->addToCart($user_id, $product_id, $product_name, $product_description, $product_image, $product_price, $product_category, $quantity);

                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => 'Impossible d\'ajouter le produit au panier.']);
                }
            } else {
                echo json_encode(['error' => 'Paramètres manquants.']);
            }
        }
    }

    public function updateQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['cart_id']) && isset($data['quantity'])) {
                $cart_id = $data['cart_id'];
                $quantity = (int)$data['quantity'];

                if ($quantity > 0) {
                    $result = $this->cartModel->updateQuantity($cart_id, $quantity);

                    if ($result) {
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['error' => 'Impossible de mettre à jour la quantité.']);
                    }
                } else {
                    echo json_encode(['error' => 'La quantité doit être supérieure à zéro.']);
                }
            } else {
                echo json_encode(['error' => 'Paramètres manquants.']);
            }
        }
    }

    public function removeFromCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['cart_id'])) {
                $cart_id = $data['cart_id'];

                $result = $this->cartModel->removeFromCart($cart_id);

                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['error' => 'Impossible de supprimer le produit.']);
                }
            } else {
                echo json_encode(['error' => 'Paramètre cart_id manquant.']);
            }
        }
    }
}


$database = new Database();
$db = $database->getConnection();


$cartController = new CartController($db);


session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}


$user_id = $_SESSION['user']['id'];


$cartItems = $cartController->getCartItems($user_id);


$totalAmount = 0;
foreach ($cartItems as $item) {
    $totalAmount += $item['product_price'] * $item['quantity'];
}

// cette partie est juste pour le routage
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'addToCart':
        $cartController->addToCart();
        break;
    case 'updateQuantity':
        $cartController->updateQuantity();
        break;
    case 'removeFromCart':
        $cartController->removeFromCart();
        break;
}
?>
