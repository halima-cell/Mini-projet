<?php
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['cart'])) {
    header('Location: panier.php');
    exit;
}
try {
    $pdo = new PDO('mysql:host=localhost;dbname=librairie', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = array_sum(array_column($_SESSION['cart'], 'prix'));
    $user_id = $_SESSION['user']['id'];
    
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->execute([$user_id, $total]);
    
    unset($_SESSION['cart']);
    
    $message = "Paiement réussi ! Commande enregistrée.";
    header('Location: index.php?success=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Librairie</a>
            <div class="navbar-nav">
                <a class="nav-link" href="catalogue.php">Catalogue</a>
                <a class="nav-link" href="panier.php">Panier</a>
                <a class="nav-link" href="compte.php">Mon Compte</a>
                <a class="nav-link" href="logout.php">Déconnexion</a>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Paiement</h1>
        <p>Total à payer : <?= array_sum(array_column($_SESSION['cart'], 'prix')) ?>€</p>
        <div class="form-section">
            <form method="POST">
                <div class="mb-3">
                    <label for="card_number" class="form-label">Numéro de Carte</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
                </div>
                <div class="mb-3">
                    <label for="expiry" class="form-label">Date d'Expiration</label>
                    <input type="text" class="form-control" id="expiry" name="expiry" placeholder="MM/AA" required>
                </div>
                <div class="mb-3">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Adresse de Livraison</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-success">Payer</button>
            </form>
        </div>
    </div>
</body>
</html>