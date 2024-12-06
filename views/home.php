<?php
include "../controllers/ProductController.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoeShop - Boutique de Chaussures</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       
        :root {
            --primary-color: #1c1c1e; 
            --secondary-color: #2c2c2e; 
            --highlight-color: #00adb5; 
            --accent-color: #ff5722;
            --text-color: #e0e0e0; 
            --border-color: #3a3a3c; 
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--primary-color);
            color: var(--text-color);
        }

        header {
            background-color: var(--secondary-color);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        header .navbar-brand {
            font-size: 2rem;
            font-weight: bold;
            color: var(--highlight-color);
        }
        header .nav-link {
            color: var(--text-color);
            font-size: 1rem;
            font-weight: 500;
            margin-right: 15px;
            transition: color 0.3s ease;
        }
        header .nav-link:hover {
            color: var(--highlight-color);
        }
        header .btn {
            background-color: var(--accent-color);
            color: var(--text-color);
            font-weight: bold;
            border-radius: 25px;
            padding: 8px 25px;
            transition: all 0.3s ease;
        }
        header .btn:hover {
            background-color: var(--highlight-color);
            color: var(--secondary-color);
        }

        
        .hero {
            background: url('https://source.unsplash.com/1600x900/?shoes,dark') no-repeat center center/cover;
            height: 210px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            color: white;
            box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.5);
        }
        .hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            color:var(--accent-color);
        }
        .hero p {
            font-size: 1.2rem;
            font-weight: 400;
            margin-top: 10px;
        }

        /* Section Produits */
        .products-section {
            padding: 50px 15px;
            background-color: var(--primary-color);
        }
        .products-section h3 {
            text-align: center;
            margin-bottom: 40px;
            font-weight: bold;
            color: var(--highlight-color);
        }
        .card {
            border: none;
            border-radius: 15px;
            background-color: var(--secondary-color);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
        }
        .card img {
            height: 250px;
            object-fit: cover;
            border-bottom: 3px solid var(--accent-color);
        }
        .card-body {
            padding: 20px;
            text-align: center;
        }
        .card-title {
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--highlight-color);
        }
        .card-text {
            font-size: 1rem;
            color: var(--text-color);
        }
        .btn-buy {
            background-color: var(--highlight-color);
            color: var(--primary-color);
            font-weight: bold;
            border-radius: 25px;
            padding: 10px 25px;
            transition: all 0.3s ease;
        }
        .btn-buy:hover {
            background-color: var(--accent-color);
            color: white;
        }

       
        footer {
            background-color: var(--secondary-color);
            padding: 30px 0;
            text-align: center;
            color: var(--text-color);
            border-top: 1px solid var(--border-color);
        }
        footer .social-links a {
            color: var(--highlight-color);
            font-size: 1.5rem;
            margin: 0 15px;
            transition: color 0.3s ease;
        }
        footer .social-links a:hover {
            color: var(--accent-color);
        }

        footer .credit {
            margin-top: 15px;
            font-size: 0.9rem;
            font-weight: 400;
        }
    </style>
</head>
<body>
    
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="#">ShoeShop</a>
                <div class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a href="./login.php" class="nav-link">Connexion</a></li>
                        <li class="nav-item"><a href="./admin_login.php" class="nav-link">Admin</a></li>
                        <li class="nav-item"><a href="./inscriptions.php" class="btn">Inscription</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

   
    <div class="hero">
        <div>
            <h1>Découvrez votre style</h1>
            <p>Les meilleures chaussures, au meilleur prix</p>
        </div>
    </div>

   
    <div class="products-section container">
        <h3>Nos meilleurs Offres</h3>
        <div class="row">
            <?php if (!empty($productsUnder40)) : ?>
                <?php foreach ($productsUnder40 as $product) : ?>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card">
                            <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="card-text"><strong>Prix :</strong> <?php echo htmlspecialchars($product['prix']); ?> $</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center">Aucune offre disponible pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>

  
    <footer>
        <div class="container">
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
            <div class="credit">© 2024 ShoeShop. Tous droits réservés.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
