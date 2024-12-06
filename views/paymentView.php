<?php
session_start();
if (!isset($_SESSION['total_price'])) {
    echo "Erreur: Le montant total n'est pas disponible.";
    exit;
}

$total_price = $_SESSION['total_price'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e1e2e;
            --secondary-color: #2c2c3e;
            --highlight-color: #00adb5;
            --accent-color: #ff5722;
            --text-color: #e5e5e5;
            --border-color: #3a3a3a;
        }

        body {
            background-color: var(--primary-color);
            color: var(--text-color);
        }

        .container {
            max-width: 800px;
            margin-top: 80px;
            padding: 20px;
            border-radius: 8px;
            background-color: var(--secondary-color);
        }

        h1.heading {
            font-size: 2rem;
            color: var(--highlight-color);
            margin-bottom: 30px;
        }

        .btn {
            background-color: var(--accent-color);
            color: var(--text-color);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: var(--highlight-color);
            color: var(--primary-color);
        }

        .paypal-button-container {
            margin-top: 40px;
        }

        .paypal-button-container iframe {
            max-width: 100%;
        }
    </style>
    <script src="https://www.paypal.com/sdk/js?client-id=AURoClKTofgpvyisGertGKUDBCL8EeB_3z1ytZ3X6A9pndUHk9dKjIncdTTmL8-wn4XxW6hGxH3FRakG&currency=CAD"></script>
</head>
<body>

<div class="container text-center">
    <h1 class="heading">Paiement avec PayPal</h1>

    <div id="paypal-button-container" class="paypal-button-container"></div>

    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $total_price; ?>' 
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Transaction complétée par ' + details.payer.name.given_name);
                  
                    window.location.href = "success.php?orderID=" + data.orderID;
                });
            }
        }).render('#paypal-button-container'); 
    </script>

       <form action="../public/index.php?controller=auth&action=logout" method="POST" style="display: inline;">
                <button type="submit" class="btn">Déconnexion</button>
            </form>
</div>

</body>
</html>
