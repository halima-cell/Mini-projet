<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Librairie en Ligne</title>
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
                <?php session_start(); if (isset($_SESSION['user'])): ?>
                    <a class="nav-link" href="compte.php">Mon Compte</a>
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                <?php else: ?>
                    <a class="nav-link" href="login.php">Connexion</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Bienvenue à notre Librairie</h1>
        <p>Recherche rapide :</p>
        <form action="catalogue.php" method="GET">
            <input type="text" name="search" placeholder="Titre ou auteur" class="form-control">
            <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
        </form>
    </div>
</body>
</html>