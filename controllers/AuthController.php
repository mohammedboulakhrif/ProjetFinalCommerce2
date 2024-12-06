<?php
require_once '../config/Database.php';
require_once '../models/User.php';

class AuthController {
    private function initDatabase() {
        $database = new Database();
        return $database->getConnection();
    }

    
    public function register() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
    
            
            if (empty($email) || empty($password) || empty($confirm_password)) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                header("Location: ../views/inscriptions.php");
                exit();
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Adresse email invalide.";
                header("Location: ../views/inscriptions.php");
                exit();
            }
            if ($password !== $confirm_password) {
                $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
                header("Location: ../views/inscriptions.php");
                exit();
            }
            if (strlen($password) < 6) {
                $_SESSION['error'] = "Le mot de passe doit contenir au moins 6 caractères.";
                header("Location: ../views/inscriptions.php");
                exit();
            }
    
            try {
                $db = $this->initDatabase();
                $userModel = new User($db);
                $message = $userModel->register($email, $password);
                if ($message === "Inscription réussie.") {
                    $_SESSION['success'] = "Compte créé avec succès. Veuillez vous connecter.";
                    header("Location: ../views/login.php");
                } else {
                    $_SESSION['error'] = $message;
                    header("Location: ../views/inscriptions.php");
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de l'inscription : " . $e->getMessage();
                header("Location: ../views/inscriptions.php");
            }
            exit();
        }
    }

    
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
    
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                header("Location: ../views/login.php");
                exit();
            }
    
            try {
                $db = $this->initDatabase();
                $userModel = new User($db);
                $user = $userModel->login($email, $password);
                if ($user) {
                    $_SESSION['user'] = $user;
                    $_SESSION['success'] = "Connexion réussie.";
                    header("Location: ../views/index.php");
                } else {
                    $_SESSION['error'] = "Email ou mot de passe incorrect.";
                    header("Location: ../views/login.php");
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de la connexion : " . $e->getMessage();
                header("Location: ../views/login.php");
            }
            exit();
        }
    }

    public function loginAdmin() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
    
            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                header("Location: ../views/admin_login.php");
                exit();
            }
    
            try {
                $database = new Database();
                $db = $database->getConnection();
                $userModel = new User($db);
    
               
                $admin = $userModel->loginAdmin($email, $password);
                if ($admin) {
                    $_SESSION['user'] = $admin;
                    $_SESSION['success'] = "Connexion administrateur réussie.";
                    header("Location: ../views/adminVue.php"); 
                } else {
                    $_SESSION['error'] = "Email ou mot de passe incorrect pour administrateur.";
                    header("Location: ../views/admin_login.php");
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Erreur lors de la connexion administrateur : " . $e->getMessage();
                header("Location: ../views/admin_login.php");
            }
            exit();
        }
    }
   
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
        header("Location: ../views/home.php");
        exit();
    }
}
?>
