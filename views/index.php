<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include "../controllers/ProductController.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #1e1e2e;
            --secondary-color: #2c2c3e;
            --highlight-color: #00adb5;
            --accent-color: #ff5722;
            --text-color: #e5e5e5;
            --border-color: #3a3a4e;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--primary-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        header {
            background-color: var(--secondary-color);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        header .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--highlight-color);
        }

        header .navbar-brand:hover {
            text-decoration: none;
            color: var(--accent-color);
        }

        header .cart-icon {
            font-size: 1.5rem;
            color: var(--highlight-color);
            margin-right: 15px;
        }

        header .cart-icon:hover {
            color: var(--accent-color);
        }

        header .btn {
            background-color: var(--accent-color);
            color: white;
            font-weight: bold;
            border-radius: 5px;
            padding: 8px 20px;
            transition: background-color 0.3s ease;
        }

        header .btn:hover {
            background-color: var(--highlight-color);
        }

        h2 {
            text-align: center;
            color: var(--highlight-color);
            margin: 20px 0;
        }

        .product-card {
            background-color: var(--secondary-color);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-card img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .product-card .product-info {
            padding: 15px;
        }

        .product-card .product-info h5 {
            color: var(--highlight-color);
            font-size: 1.2rem;
            margin: 10px 0;
        }

        .product-card .product-info p {
            margin: 5px 0;
        }

        .product-card .btn {
            margin-top: 10px;
            background-color: var(--highlight-color);
            color: var(--primary-color);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .product-card .btn:hover {
            background-color: var(--accent-color);
            color: white;
        }

        footer {
            background-color: var(--secondary-color);
            padding: 15px;
            text-align: center;
            color: var(--text-color);
            border-top: 1px solid var(--border-color);
        }

        footer a {
            color: var(--highlight-color);
            margin: 0 10px;
            font-size: 1.2rem;
            text-decoration: none;
        }

        footer a:hover {
            color: var(--accent-color);
        }


        
        .filter-form {
            background-color: var(--secondary-color);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .filter-form input, .filter-form select {
            background-color: var(--primary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            padding: 10px;
            border-radius: 5px;
        }

        .filter-form button {
            background-color: var(--highlight-color);
            color: var(--primary-color);
            border: none;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: var(--accent-color);
        }


    </style>
</head>
<body>
    <header>
        <a href="" class="navbar-brand">ShoeShop</a>
        <div>
            <a href="cart.php"><i class="fas fa-shopping-cart cart-icon"></i></a>
            <form action="../public/index.php?controller=auth&action=logout" method="POST" style="display: inline;">
                <button type="submit" class="btn">Déconnexion</button>
            </form>
        </div>
    </header>

    <div class="container">
        <h2>Produits Disponibles</h2>

    
    <div class="d-flex justify-content-center mb-4">
        <form method="GET" class="filter-form d-flex">
            <select name="category">
                <option value="">Toutes les catégories</option>
                <option value="Air Force" <?php if ($category === 'Air Force') echo 'selected'; ?>>Air Force</option>
                <option value="Revolution" <?php if ($category === 'Revolution') echo 'selected'; ?>>Revolution</option>
                <option value="Dunk Low" <?php if ($category === 'Dunk Low') echo 'selected'; ?>>Dunk Low</option>
                <option value="Blazer" <?php if ($category === 'Blazer') echo 'selected'; ?>>Blazer</option>
                <option value="Air Max" <?php if ($category === 'Air Max') echo 'selected'; ?>>Air Max</option>
            </select>
            <input type="number" name="price_min" placeholder="Prix Min" value="<?php echo htmlspecialchars($price_min); ?>">
            <input type="number" name="price_max" placeholder="Prix Max" value="<?php echo htmlspecialchars($price_max); ?>">
            <button type="submit" class="btn">Filtrer</button>
        </form>
    </div>


        <div class="row">
            <?php if (!empty($products)) : ?>
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-4">
                        <div class="product-card">
                            <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <div class="product-info">
                                <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p><?php echo htmlspecialchars($product['description']); ?></p>
                                <p><strong>Prix :</strong> <?php echo htmlspecialchars($product['prix']); ?> $</p>
                                <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                                <button class="btn add-to-cart"
                                    data-id="<?php echo $product['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($product['name']); ?>"
                                    data-description="<?php echo htmlspecialchars($product['description']); ?>"
                                    data-image="<?php echo htmlspecialchars($product['image']); ?>"
                                    data-price="<?php echo $product['prix']; ?>"
                                    data-category="<?php echo htmlspecialchars($product['category']); ?>">
                                    Ajouter au Panier
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="text-center">Aucun produit trouvé pour ces critères.</p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <div>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
        <p>&copy; 2024 ShoeShop. Tous droits réservés.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', () => {
                const product = {
                    product_id: button.getAttribute('data-id'),
                    product_name: button.getAttribute('data-name'),
                    product_description: button.getAttribute('data-description'),
                    product_image: button.getAttribute('data-image'),
                    product_price: button.getAttribute('data-price'),
                    product_category: button.getAttribute('data-category'),
                    quantity: 1
                };

                fetch('../controllers/CartController.php?action=addToCart', {
                    method: 'POST',
                    body: JSON.stringify(product),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).catch(error => console.error('Erreur :', error));
            });
        });
    </script>
</body>
</html>