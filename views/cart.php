<?php
require_once '../controllers/CartController.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier</title>
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        header {
            background-color: var(--secondary-color);
            color: var(--text-color);
            padding: 15px 20px;
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

        header .btn-secondary {
            background-color: transparent;
            color: var(--highlight-color);
            border: 1px solid var(--border-color);
            padding: 8px 20px;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        header .btn-secondary:hover {
            background-color: var(--accent-color);
            color: white;
        }

        h1 {
            color: var(--highlight-color);
            text-align: center;
            margin: 20px 0;
        }

        /* Table Panier */
        .table {
            color: var(--text-color);
            background-color: var(--secondary-color);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .table img {
            border-radius: 8px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-controls button {
            background-color: var(--highlight-color);
            color: var(--primary-color);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .quantity-controls button:hover {
            background-color: var(--accent-color);
            color: white;
        }

        .remove-item {
            background-color: var(--highlight-color);
            color: var(--primary-color);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .remove-item:hover {
            background-color: var(--accent-color);
            color: white;
        }

        .btn-primary {
            background-color: var(--highlight-color);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--accent-color);
        }

        .btn-center {
            display: block;
            margin: 30px auto 20px auto; 
            text-align: center;
        }

        .container {
            flex: 1;
        }

        footer {
            text-align: center;
            margin-top: auto;
            padding: 15px;
            background-color: var(--secondary-color);
        }

        footer a {
            color: var(--highlight-color);
            text-decoration: none;
            margin: 0 10px;
        }

        footer a:hover {
            color: var(--accent-color);
        }
    </style>
</head>
<body>
 
    <header>
        <a href="home.php" class="navbar-brand">ShoeShop</a>
        <div>
            <a href="index.php" class="btn btn-secondary">Retour à la boutique</a>
        </div>
    </header>

    <div class="container">
        <h1>Votre Panier</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Description</th>
                    <th>Prix unité</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cartItems)) : ?>
                    <?php foreach ($cartItems as $item) : ?>
                        <tr data-id="<?php echo $item['id']; ?>">
                            <td>
                                <img src="../uploads/<?php echo htmlspecialchars($item['product_image']); ?>" width="60" alt="Produit">
                                <?php echo htmlspecialchars($item['product_name']); ?>
                            </td>
                            <td><?php echo htmlspecialchars($item['product_description']); ?></td>
                            <td><?php echo number_format($item['product_price'], 2); ?> $</td>
                            <td>
                                <div class="quantity-controls">
                                    <button class="decrease-quantity" data-cart-id="<?php echo $item['id']; ?>">-</button>
                                    <span class="quantity-value"><?php echo $item['quantity']; ?></span>
                                    <button class="increase-quantity" data-cart-id="<?php echo $item['id']; ?>">+</button>
                                </div>
                            </td>
                            <td class="total-price"><?php echo number_format($item['product_price'] * $item['quantity'], 2); ?> $</td>
                            <td>
                                <button class="remove-item" data-cart-id="<?php echo $item['id']; ?>">✖</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Votre panier est vide.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="checkout.php" class="btn btn-primary btn-center">Passer à la commande</a>
    </div>

   
    <footer>
        <div>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>           
        </div>
        <p>&copy; 2024 ShoeShop. Tous droits réservés.</p>
    </footer>
    <script>
  
    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', () => {
            const cartId = button.getAttribute('data-cart-id');
            const row = document.querySelector(`tr[data-id="${cartId}"]`);
            const quantitySpan = row.querySelector('.quantity-value');
            let quantity = parseInt(quantitySpan.textContent);

            if (quantity > 1) {
                quantity--;
                updateQuantity(cartId, quantity, row);
            }
        });
    });

    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', () => {
            const cartId = button.getAttribute('data-cart-id');
            const row = document.querySelector(`tr[data-id="${cartId}"]`);
            const quantitySpan = row.querySelector('.quantity-value');
            let quantity = parseInt(quantitySpan.textContent);

            quantity++;
            updateQuantity(cartId, quantity, row);
        });
    });

    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', () => {
            const cartId = button.getAttribute('data-cart-id');

            fetch('../controllers/CartController.php?action=removeFromCart', {
                method: 'POST',
                body: JSON.stringify({ cart_id: cartId }),
                headers: { 'Content-Type': 'application/json' }
            }).then(response => response.json())
              .then(data => {
                  if (data.success) {
                      const row = document.querySelector(`tr[data-id="${cartId}"]`);
                      row.remove();
                  } else {
                      alert(data.error);
                  }
              })
              .catch(error => console.error('Erreur :', error));
        });
    });

    function updateQuantity(cartId, quantity, row) {
        fetch('../controllers/CartController.php?action=updateQuantity', {
            method: 'POST',
            body: JSON.stringify({ cart_id: cartId, quantity: quantity }),
            headers: { 'Content-Type': 'application/json' }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  const price = parseFloat(row.querySelector('td:nth-child(3)').textContent);
                  row.querySelector('.quantity-value').textContent = quantity;
                  row.querySelector('.total-price').textContent = (price * quantity).toFixed(2) + ' €';
              } else {
                  alert(data.error);
              }
          })
          .catch(error => console.error('Erreur :', error));
    }
</script>

</body>
</html>
