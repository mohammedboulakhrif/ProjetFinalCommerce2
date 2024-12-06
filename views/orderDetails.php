<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Commande</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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

        .container {
            width: 80%;
            margin: 30px auto;
            background: var(--secondary-color);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            color: var(--highlight-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        tr:nth-child(even) {
            background-color: var(--secondary-color);
        }

        tr:hover {
            background-color: var(--highlight-color);
            color: var(--primary-color);
        }

        td img {
            border-radius: 5px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: var(--highlight-color);
            font-weight: bold;
            padding: 10px 20px;
            border: 2px solid var(--highlight-color);
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: var(--highlight-color);
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Détails de la Commande</h1>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Image</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orderItems)) : ?>
                    <?php foreach ($orderItems as $item) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>
                                <img src="../uploads/<?php echo htmlspecialchars($item['product_image']); ?>" 
                                     alt="Image du produit" 
                                     style="width: 50px; height: 50px;">
                            </td>
                            <td><?php echo htmlspecialchars($item['price']); ?> €</td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Aucun produit trouvé pour cette commande.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="text-center">
            <a href="../views/adminVue.php">← Retour au tableau de bord</a>
        </div>
    </div>
</body>
</html>
