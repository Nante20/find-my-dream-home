<?php
session_start();
?>
<?php
    $isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Find My Dream Home</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js" defer></script>
</head>
<header>
        <nav>
        <div class="nav-left">Find My Dream Home</div>
        <div class="nav-right">
             <?php if (!$isLoggedIn): ?>
                <a href="login.php">Login</a>
            <?php else: ?>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
            <a href="../pages/register.php">Register</a>
            <a href="../index.php">House</a>
            <a href="../index.php">Appartement</a>
            <a href="../pages/add.php">Add</a>
            
        </div> 
    </nav>
</header>