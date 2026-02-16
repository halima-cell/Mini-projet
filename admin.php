<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
}
try {
    $pdo = new PDO('mysql:host=localhost;dbname=librairie', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO books (titre, auteur, prix, stock, image, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['titre'], $_POST['auteur'], $_POST['prix'], $_POST['stock'], $_POST['image'], $_POST['description']]);
    } elseif (isset($_POST['delete'])) {
        $stmt = $pdo->prepare("DELETE FROM books WHERE id=?");
        $stmt->execute([$_POST['id']]);
    }
}
$books = $pdo->query("SELECT * FROM books")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
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
                <a class="nav-link" href="logout.php">Déconnexion</a>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Espace Admin</h1>
        <div class="form-section">
            <h2>Ajouter un Livre</h2>
            <form method="POST">
                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" required>
                </div>
                <div class="mb-3">
                    <label for="auteur" class="form-label">Auteur</label>
                    <input type="text" class="form-control" id="auteur" name="auteur" required>
                </div>
                <div class="mb-3">
                    <label for="prix" class="form-label">Prix</label>
                    <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">URL Image</label>
                    <input type="text" class="form-control" id="image" name="image">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <button type="submit" name="add" class="btn btn-primary">Ajouter Livre</button>
            </form>
        </div>
        <h2>Livres Existants</h2>
        <table class="table">
            <thead>
                <tr><th>ID</th><th>Titre</th><th>Auteur</th><th>Prix</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= $book['id'] ?></td>
                        <td><?= $book['titre'] ?></td>
                        <td><?= $book['auteur'] ?></td>
                        <td><?= $book['prix'] ?>€</td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $book['id'] ?>">
                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>