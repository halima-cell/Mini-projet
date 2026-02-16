<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=librairie', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }

    if (isset($_POST['login'])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$_POST['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($_POST['password'], $user['mot_de_passe'])) {
            $_SESSION['user'] = $user;
            header('Location: index.php');
        } else {
            $error = "Identifiants incorrects.";
        }
    } elseif (isset($_POST['register'])) {
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, mot_de_passe, role) VALUES (?, ?, ?, 'client')");
        $stmt->execute([$_POST['nom'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT)]);
        $success = "Inscription réussie ! Connectez-vous.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Connexion</h1>
        <?php if (isset($error)): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
        <?php if (isset($success)): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
        <div class="form-section">
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Se Connecter</button>
            </form>
        </div>
        <h2>Inscription</h2>
        <div class="form-section">
            <form method="POST">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="mb-3">
                    <label for="email_reg" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email_reg" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password_reg" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password_reg" name="password" required>
                </div>
                <button type="submit" name="register" class="btn btn-success">S'Inscrire</button>
            </form>
        </div>
    </div>
</body>
</html>