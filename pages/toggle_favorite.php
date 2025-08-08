<?php
session_start();
require __DIR__ . '/../config/database.php';

if (!isset($_SESSION['loggedin']) || !isset($_POST['listing_id'])) {
    header("Location: ../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$listing_id = (int) $_POST['listing_id'];

// Vérifie si l'annonce est déjà en favori
$sql = "SELECT * FROM favorite WHERE user_id = ? AND listing_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $listing_id]);
$isFav = $stmt->fetch();

if ($isFav) {
    // Retirer des favoris
    $delete = $pdo->prepare("DELETE FROM favorite WHERE user_id = ? AND listing_id = ?");
    $delete->execute([$user_id, $listing_id]);
} else {
    // Ajouter en favori
    $insert = $pdo->prepare("INSERT INTO favorite (user_id, listing_id) VALUES (?, ?)");
    $insert->execute([$user_id, $listing_id]);
}

// Recharge les favoris dans la session
$favs = $pdo->prepare("SELECT listing_id FROM favorite WHERE user_id = ?");
$favs->execute([$user_id]);
$_SESSION['favorites'] = array_column($favs->fetchAll(PDO::FETCH_ASSOC), 'listing_id');

header("Location: ../index.php");
exit;
