<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ShoeShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    
        :root {
            --primary-color: #1c1c1e;
            --secondary-color: #2c2c2e;
            --highlight-color: #00adb5; 
            --accent-color: #ff5722;
            --text-color: #e0e0e0; 
            --input-bg: #343a40; 
            --input-border: #444; 
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--primary-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background-color: var(--secondary-color);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }

        h2 {
            color: var(--highlight-color);
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-control {
            background-color: var(--input-bg);
            color: var(--text-color);
            border: 1px solid var(--input-border);
            border-radius: 5px;
        }

        .form-control:focus {
            border-color: var(--highlight-color);
            box-shadow: 0 0 4px var(--highlight-color);
        }

        .btn-primary {
            background-color: var(--accent-color);
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-primary:hover {
            background-color: var(--highlight-color);
            color: var(--secondary-color);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-secondary {
            background-color: var(--highlight-color);
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            color: var(--primary-color);
            margin-top: 10px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: var(--accent-color);
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .alert {
            border-radius: 5px;
            margin-top: 10px;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: var(--highlight-color);
            text-decoration: none;
            font-weight: 500;
        }

        .register-link:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        .spinner-border {
            display: none;
            width: 1rem;
            height: 1rem;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>

        
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
            unset($_SESSION['success']);
        }
        ?>

        <form action="../public/index.php?controller=auth&action=login" method="POST" class="mt-4" onsubmit="showLoading()">
            <div class="mb-3">
                <label for="email" class="form-label">Adresse E-mail :</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de Passe :</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
            </div>
            <button type="submit" class="btn btn-primary">
                Connexion
                <div class="spinner-border text-light" role="status" id="loadingSpinner">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </button>
        </form>

     
        <a href="home.php" class="btn btn-secondary mt-3">Retour à l'accueil</a>

      
        <a href="inscriptions.php" class="register-link">Créer un compte</a>
    </div>

    <script>
       
        function showLoading() {
            document.getElementById("loadingSpinner").style.display = "inline-block";
        }
    </script>
</body>
</html>
