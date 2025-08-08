<?php
session_start();
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Find My Dream Home</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/script.js" defer></script>
</head>
<header>
    <nav>
        <div class="nav-left">Find My Dream Home</div>
        <div class="nav-right">
            <?php if (!$isLoggedIn): ?>
                <a href="/pages/login.php">Login</a>
                <a href="/pages/register.php">Register</a>
            <?php else: ?>
                <a href="/pages/logout.php">Logout</a>
                <a href="/pages/add.php">Add</a>
                <a href="/pages/favorites.php">Favorites</a>
            <?php endif; ?>

            <a href="/pages/house.php">House</a>
            <a href="/pages/appartment.php">Apartment</a>
        </div> 
    </nav>
</header>
