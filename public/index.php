<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


class App
{
    private $controllerName;
    private $action;

    public function __construct()
    {

        $this->controllerName = isset($_GET['controller']) ? ucfirst(strtolower($_GET['controller'])) . 'Controller' : 'HomeController';
        $this->action = isset($_GET['action']) ? strtolower($_GET['action']) : 'index';
    }

  
    public function autoloadController($class)
    {
        $file = "../controllers/" . $class . ".php"; 
        if (file_exists($file)) {
            require_once $file;
        } else {
            throw new Exception("Le fichier contrôleur $class n'a pas été trouvé.");
        }
    }

   
    public function handleRequest()
    {
        try {
          
            spl_autoload_register([$this, 'autoloadController']);

          
            if (!class_exists($this->controllerName)) {
                throw new Exception("Le contrôleur '$this->controllerName' n'existe pas.");
            }

            $controller = new $this->controllerName();

            
            if (!method_exists($controller, $this->action)) {
                throw new Exception("L'action '$this->action' n'existe pas dans le contrôleur '$this->controllerName'.");
            }

            
            $controller->{$this->action}();
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

   
    private function handleError($e)
    {
        echo "<h1>Erreur</h1>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    }
}


$app = new App();
$app->handleRequest();

?>
