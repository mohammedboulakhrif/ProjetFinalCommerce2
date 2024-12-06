<?php
session_start();

require_once 'PaymentModel.php';

class PaymentController {
    private $paymentModel;

    public function __construct($db) {
        $this->paymentModel = new PaymentModel($db);
    }

    public function processPayment() {
        if (!isset($_SESSION['user_id'])) {
            header('location:login.php');
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $payment_method = isset($_GET['method']) ? $_GET['method'] : '';
        $order_id = $_SESSION['order_id'];
        $total_price = $this->paymentModel->getOrderTotalPrice($order_id);

        include 'views/paymentView.php';
    }
}
?>
