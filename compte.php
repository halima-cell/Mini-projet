<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client') {
    header('Location: login.php');
    exit;
}
try {
    $pdo = new PDO('mysql:host=localhost;dbname=librairie', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $_SESSION['user']['mot_de_passe'];
    
    $stmt = $pdo->prepare("UPDATE users SET nom = ?, email = ?, mot_de_passe = ? WHERE id = ?");
    $stmt->execute([$nom, $email, $password, $_SESSION['user']['id']]);
    
    $_SESSION['user']['nom'] = $nom;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['mot_de_passe'] = $password;
    
    $message = "Profil mis à jour avec succès !";
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Compte</title>
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
        <h1>Mon Compte</h1>
        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>
        <div class="form-section">
            <form method="POST">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= $user['nom'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau Mot de Passe (laisser vide pour ne pas changer)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Mettre à Jour</button>
            </form>
        </div>
    </div>
</body>
</html>