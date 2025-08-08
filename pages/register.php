<?php
session_start();
require __DIR__ . '/../config/database.php';
include __DIR__ . '/../includes/header.php';

$erreur = "";
$success = "";

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirm = htmlspecialchars(trim($_POST['confirm_password']));

    if (empty($email) || empty($password) || empty($confirm)) {
        $erreur = "Veuillez remplir tous les champs.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    } elseif (strlen($password) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
    } elseif ($password !== $confirm) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifie si l'email existe déjà
        $check = $pdo->prepare("SELECT id FROM user WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetch()) {
            $erreur = "Un compte avec cet email existe déjà.";
        } else {
            // Insertion (sans hash pour l’instant)
            $stmt = $pdo->prepare("INSERT INTO user (email, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$email, $password, 'user']);
            $success = "✅ Compte créé avec succès. Vous pouvez vous connecter.";
        }
    }
}
?>

<div class="container">
    <h1>Créer un compte</h1>

    <?php if (!empty($erreur)): ?>
        <div class="error"><?= $erreur ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form method="post">
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="<?= isset($email) ? $email : '' ?>" required>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" id="confirm_password" required>

        <button type="submit">S’inscrire</button>
    </form>

    <p>Déjà inscrit ? <a href="login.php">Connectez-vous ici</a></p>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
