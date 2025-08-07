<?php include __DIR__ . '/../includes/header.php';
      require __DIR__ . '/../config/database.php';
?>

<div class="container">
    <h1>Créer un compte sur Find My Dream Home</h1>

<?php
$erreur = "";
$success = "";

// Validation côté serveur
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirm_password']));

    if (empty($email) || empty($password) || empty($confirmPassword)) {
        $erreur = "Veuillez remplir tous les champs.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "L'adresse email est invalide.";
    } elseif (strlen($password) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif ($password !== $confirmPassword) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        $success = "✅ Inscription réussie ! (Données valides)";
    }
}
?>

<?php if (!empty($erreur)): ?>
    <div class="error"><?= $erreur ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

    <form id="registerForm" action="" method="post">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= isset($email) ? $email : '' ?>" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <div id="clientError" class="error"></div>

        <button type="submit">S’inscrire</button>
    </form>

    <p>Déjà inscrit ? <a href="/pages/login.php">Connectez-vous</a></p>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>




