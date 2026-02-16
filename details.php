<?php
session_start();
$id = $_GET['id'];
try {
    $pdo = new PDO('mysql:host=localhost;dbname=librairie', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $_SESSION['cart'][] = $book;
    header('Location: panier.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails</title>
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
        <div class="row">
            <div class="col-md-6">
                <img src="<?= $book['image'] ?>" class="img-fluid" alt="Image">
            </div>
            <div class="col-md-6">
                <h1><?= $book['titre'] ?></h1>
                <p>Auteur: <?= $book['auteur'] ?></p>
                <p>Prix: <?= $book['prix'] ?>€</p>
                <p>Description: <?= $book['description'] ?></p>
                <p>Stock: <?= $book['stock'] > 0 ? 'Disponible' : 'Indisponible' ?></p>
                <form method="POST">
                    <button type="submit" name="add_to_cart" class="btn btn-success" <?= $book['stock'] <= 0 ? 'disabled' : '' ?>>Ajouter au Panier</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>