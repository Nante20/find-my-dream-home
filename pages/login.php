<?php
session_start();
require __DIR__ . '/../config/database.php';
include __DIR__ . '/../includes/header.php';
?>

<div class="container">
    <h1>Connexion à Find My Dream Home</h1>

    <?php
    $erreur = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));

        if (empty($email) || empty($password)) {
            $erreur = "Veuillez remplir tous les champs.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreur = "L'adresse email est invalide.";
        } else {
            // Vérification en BDD
            $sql = "SELECT * FROM user WHERE email = :email AND password = :password";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'email' => $email,
                'password' => $password // pas de hash ici pour l'instant
            ]);

            $user = $stmt->fetch();

            if ($user) {
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                
// Charger les favoris de l'utilisateur connecté
$favStmt = $pdo->prepare("SELECT listing_id FROM favorite WHERE user_id = ?");
$favStmt->execute([$user['id']]);
$_SESSION['favorites'] = array_column($favStmt->fetchAll(PDO::FETCH_ASSOC), 'listing_id');

                header("Location: /index.php");
                exit;
            } else {
                $erreur = "Identifiants incorrects.";
            }
        }
    }

    if (!empty($erreur)) {
        echo "<div class='error'>$erreur</div>";
    }
    ?>

    <form action="" method="post">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>

    <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
