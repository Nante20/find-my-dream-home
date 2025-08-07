
<?php
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../config/database.php';
?>
<div class="container">
    <h1>Connexion à Find My Dream Home</h1>

<?php
$erreur = "";
$success = "";

// Simuler un utilisateur existant
$valid_email = "nata@gmail.com";
$valid_password = "123456"; // minimum 6 caractères

// Validation côté serveur
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($email) || empty($password)) {
        $erreur = "Veuillez remplir tous les champs.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "L'adresse email est invalide.";
    } elseif (strlen($password) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif ($email === $valid_email && $password === $valid_password) {
        // ✅ Connexion réussie → enregistrer en session
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;

        // Redirection vers la page d'accueil
        header("Location: ../index.php");
        exit;
    } else {
        $erreur = "Identifiants incorrects.";
    }
}
?>

<?php if (!empty($erreur)): ?>
    <div class="error"><?= $erreur ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success"><?= $success ?></div>
<?php endif; ?>

    <form id="loginForm" action="" method="post">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= isset($email) ? $email : '' ?>" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <div id="clientError" class="error"></div>

        <button type="submit">Se connecter</button>
    </form>

    <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
