<?php
// header.php
session_start();
?>
<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
    <a href="logout.php">Déconnexion</a>
<?php endif; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Find My Dream Home</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<header>
        <nav>
        <div class="nav-left">Find My Dream Home</div>
        <div class="nav-right">
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="index.php">House</a>
            <a href="index.php">Appartement</a>
            <a href="add.php">Add</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>
</header>