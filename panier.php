<?php
session_start();

// Gestion de la suppression d'un livre du panier
if (isset($_GET['remove']) && isset($_SESSION['cart'])) {
    $index = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        // Réindexer l'array pour éviter les trous
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    // Rediriger pour éviter la resoumission
    header('Location: panier.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
$total = array_sum(array_column($cart, 'prix'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
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
                <?php if (isset($_SESSION['user'])): ?>
                    <a class="nav-link" href="compte.php">Mon Compte</a>
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                <?php else: ?>
                    <a class="nav-link" href="login.php">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Panier</h1>
        <?php if (empty($cart)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($cart as $index => $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $item['titre'] ?> - <?= $item['prix'] ?>€
                        <a href="panier.php?remove=<?= $index ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce livre du panier ?')">Supprimer</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="mt-3 total">Total: <?= $total ?>€</p>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="paiement.php" class="btn btn-primary">Procéder au Paiement</a>
            <?php else: ?>
                <p>Connectez-vous pour payer.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>