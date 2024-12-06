<?php
require_once '../config/Database.php';
require_once '../models/Product.php';

class ProductController {
    public function addProduct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès refusé.";
            header("Location: ../views/admin_login.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $prix = trim($_POST['prix']);
            $category = trim($_POST['category']);

           
            $targetDir = "../uploads/";
            $imageFileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $imageFileName;

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                try {
                    $database = new Database();
                    $db = $database->getConnection();
                    $productModel = new Product($db);
                    
                    if ($productModel->addProduct($name, $description, $imageFileName, $prix, $category)) {
                        $_SESSION['message'] = "Produit ajouté avec succès.";
                    } else {
                        $_SESSION['error'] = "Erreur lors de l'ajout du produit.";
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = "Erreur : " . $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Erreur lors du téléchargement de l'image.";
            }
            header("Location: ../views/adminVue.php");
            exit();
        }
    }



    public function delete() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
      
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès refusé.";
            header("Location: ../views/admin_login.php");
            exit();
        }
    
        if (isset($_GET['id'])) {
            $productId = $_GET['id'];
    
            try {
                $database = new Database();
                $db = $database->getConnection();
                $productModel = new Product($db);
    
                if ($productModel->deleteProduct($productId)) {
                    $_SESSION['message'] = "Produit supprimé avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression du produit.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur : " . $e->getMessage();
            }
        }
        header("Location: ../views/adminVue.php");
        exit();
    }

    


    public function update() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
      
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Accès refusé.";
            header("Location: ../views/admin_login.php");
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
           
            $productId = $_POST['id'];
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $prix = trim($_POST['prix']);
            $category = trim($_POST['category']);
            $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $_POST['current_image'];
    
            
            if ($_FILES['image']['name']) {
                $targetDir = "../uploads/";
                $targetFilePath = $targetDir . basename($image);
                move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);
            }
    
            try {
                $database = new Database();
                $db = $database->getConnection();
                $productModel = new Product($db);
    
                if ($productModel->updateProduct($productId, $name, $description, $image, $prix, $category)) {
                    $_SESSION['message'] = "Produit mis à jour avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de la mise à jour du produit.";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur : " . $e->getMessage();
            }
            header("Location: ../views/adminVue.php");
            exit();
        } else if (isset($_GET['id'])) {
            
            $productId = $_GET['id'];
            $database = new Database();
            $db = $database->getConnection();
            $productModel = new Product($db);
            $product = $productModel->getProductById($productId);
    
            require_once '../views/editProduct.php'; 
        }
    }




    public function getFilteredProducts() {
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        $price_min = isset($_GET['price_min']) ? $_GET['price_min'] : '';
        $price_max = isset($_GET['price_max']) ? $_GET['price_max'] : '';

       
        return $this->productModel->getFilteredProducts($category, $price_min, $price_max);
    } 


    public function showProducts() {
        $productModel = new Product($this->db);
        $products = $productModel->getAllProducts();
        require_once '../views/adminVue.php'; 
    }

    
}



require_once '../models/Product.php';
require_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();
$productModel = new Product($db);


$category = isset($_GET['category']) ? $_GET['category'] : '';
$price_min = isset($_GET['price_min']) ? $_GET['price_min'] : '';
$price_max = isset($_GET['price_max']) ? $_GET['price_max'] : '';


$products = $productModel->getFilteredProducts($category, $price_min, $price_max);

$productsUnder40 = $productModel->getFilteredProducts('', '', 120);


$productToEdit = null;
if (isset($_GET['edit_id'])) {
    $productId = $_GET['edit_id'];
    $productToEdit = $productModel->getProductById($productId); 
}