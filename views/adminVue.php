<?php
include_once '../controllers/OrderController.php';
include_once '../controllers/ProductController.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tableau de Bord</title>
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

        .container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: var(--secondary-color);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid var(--border-color);
        }

        th {
            background-color: var(--highlight-color);
            color: var(--primary-color);
        }

        td img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        tr:nth-child(even) {
            background-color: var(--primary-color);
        }

        tr:hover {
            background-color: var(--highlight-color);
            color: var(--primary-color);
        }

        .btn-modify {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-modify:hover {
            background-color: #0056b3;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #a71d2a;
        }

        .btn-view {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-view:hover {
            background-color: #218838;
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

        form {
            background-color: var(--secondary-color);
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        form label {
            color: var(--text-color);
        }

        form input, form textarea {
            background-color: var(--primary-color);
            color: var(--text-color);
            border: 1px solid var(--border-color);
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
        }

        form button {
            background-color: var(--highlight-color);
            color: var(--primary-color);
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        form button:hover {
            background-color: var(--accent-color);
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <a href="home.php" class="navbar-brand">ShoeShop</a>
        <div>
            <form action="../public/index.php?controller=auth&action=logout" method="POST">
                <button type="submit" class="btn">Déconnexion</button>
            </form>
        </div>
    </header>

    <div class="container">
        <h1>Tableau de Bord Administrateur</h1>

        <h2>Ajouter ou Modifier un Produit</h2>
        <form action="../public/index.php?controller=product&action=<?php echo $productToEdit ? 'update' : 'addProduct'; ?>" method="POST" enctype="multipart/form-data">
            <?php if ($productToEdit) : ?>
                <input type="hidden" name="id" value="<?php echo $productToEdit['id']; ?>">
                <input type="hidden" name="current_image" value="<?php echo $productToEdit['image']; ?>">
            <?php endif; ?>

            <label for="name">Nom du produit :</label>
            <input type="text" name="name" value="<?php echo $productToEdit ? htmlspecialchars($productToEdit['name']) : ''; ?>" required>

            <label for="description">Description :</label>
            <textarea name="description" required><?php echo $productToEdit ? htmlspecialchars($productToEdit['description']) : ''; ?></textarea>

            <label for="image">Image :</label>
            <input type="file" name="image" accept="image/*">
            <?php if ($productToEdit) : ?>
                <img src="../uploads/<?php echo htmlspecialchars($productToEdit['image']); ?>" width="50" height="50">
            <?php endif; ?>

            <label for="prix">Prix :</label>
            <input type="number" step="0.01" name="prix" value="<?php echo $productToEdit ? htmlspecialchars($productToEdit['prix']) : ''; ?>" required>

            <label for="category">Catégorie :</label>
            <input type="text" name="category" value="<?php echo $productToEdit ? htmlspecialchars($productToEdit['category']) : ''; ?>" required>

            <button type="submit"><?php echo $productToEdit ? 'Mettre à jour' : 'Ajouter le Produit'; ?></button>
        </form>

        <h2>Liste des Produits</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)) : ?>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Image"></td>
                            <td><?php echo htmlspecialchars($product['prix']); ?> $</td>
                            <td><?php echo htmlspecialchars($product['category']); ?></td>
                            <td>
                                <a href="adminVue.php?edit_id=<?php echo $product['id']; ?>" class="btn-modify">Modifier</a>
                                <a href="../public/index.php?controller=product&action=delete&id=<?php echo $product['id']; ?>" onclick="return confirm('Êtes-vous sûr ?');" class="btn-delete">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7">Aucun produit trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h2>Liste des Commandes</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Nom</th>
                    <th>Adresse</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)) : ?>
                    <?php foreach ($orders as $order) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['placed_on']); ?></td>
                            <td><?php echo htmlspecialchars($order['name']); ?></td>
                            <td><?php echo htmlspecialchars($order['address']); ?></td>
                            <td><?php echo htmlspecialchars($order['status']); ?></td>
                            <td><?php echo number_format($order['total_amount'], 2); ?> $</td>
                            <td>
                                <a href="../controllers/OrderItemController.php?action=viewOrderItems&order_id=<?php echo $order['id']; ?>" class="btn-view">Voir les détails</a>
                                <a href="../controllers/OrderController.php?action=delete&id=<?php echo $order['id']; ?>" class="btn btn-danger btn-sm">
        Supprimer
    </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Aucune commande trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <footer>
        <div>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
        <p>&copy; 2024 ShoeShop. Tous droits réservés.</p>
    </footer>
</body>
</html>
