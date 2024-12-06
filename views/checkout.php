<?php
require_once '../controllers/CartController.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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

        h1, h2 {
            text-align: center;
            color: var(--highlight-color);
        }

        .table th, .table td {
            color: var(--text-color);
            background-color: var(--secondary-color);
            border: 1px solid var(--border-color);
        }

        .table th {
            font-weight: bold;
        }

        .form-control {
            background-color: var(--secondary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
        }

        .form-control:focus {
            background-color: var(--primary-color);
            color: var(--text-color);
            border-color: var(--highlight-color);
        }

        .btn-danger {
            background-color: var(--accent-color);
            border: none;
        }

        .btn-danger:hover {
            background-color: var(--highlight-color);
            color: var(--primary-color);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--highlight-color);
            border: 1px solid var(--highlight-color);
        }

        .btn-secondary:hover {
            background-color: var(--highlight-color);
            color: var(--primary-color);
        }

        footer {
            background-color: var(--secondary-color);
            padding: 15px;
            text-align: center;
            color: var(--text-color);
            border-top: 1px solid var(--border-color);
            margin-top: 50px;
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
    </style>
</head>
<body>
    <header>
        <a href="" class="navbar-brand">ShoeShop</a>
        <div>
            <a href="cart.php" class="btn">Retour à la carte</a>
        </div>
    </header>

    <div class="container mt-4">
        <h1 class="text-center">Votre Commande</h1>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cartItems)) : ?>
                    <?php foreach ($cartItems as $item) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo number_format($item['product_price'], 2); ?> $</td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['product_price'] * $item['quantity'], 2); ?> $</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4" class="text-center">Votre panier est vide.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

      
        <div class="text-end mt-3 mb-4">
            <h4>Montant Total : <span class="text-success"><?php echo number_format($totalAmount, 2); ?> $</span></h4>
        </div>

        <h2 class="mt-5">Veuillez entrez vos informations personnelles</h2>
        <form action="../controllers/OrderController.php?action=placeOrder" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nom Complet</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Téléphone</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Adresse</label>
                <input type="text" name="address" id="address" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">Ville</label>
                <input type="text" name="city" id="city" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Pays</label>
                <input type="text" name="country" id="country" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="zip" class="form-label">Code Postal</label>
                <input type="text" name="zip" id="zip" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger w-100 mt-3">Passer la commande</button>
        </form>
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
</body>
</html>
