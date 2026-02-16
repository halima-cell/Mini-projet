<?php
session_start();
try {
    $pdo = new PDO('mysql:host=localhost;dbname=librairie', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$search = $_GET['search'] ?? '';
$query = "SELECT * FROM books WHERE titre LIKE ? OR auteur LIKE ?";
$stmt = $pdo->prepare($query);
$stmt->execute(["%$search%", "%$search%"]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue</title>
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
        <h1>Catalogue</h1>
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= $book['image'] ?>" class="card-img-top" alt="Image">
                        <div class="card-body">
                            <h5 class="card-title"><?= $book['titre'] ?></h5>
                            <p class="card-text">Auteur: <?= $book['auteur'] ?> | Prix: <?= $book['prix'] ?>€</p>
                            <a href="details.php?id=<?= $book['id'] ?>" class="btn btn-primary">Voir Détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>