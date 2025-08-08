<?php
session_start();
require __DIR__ . '/../config/database.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['error'] = "Veuillez vous connecter.";
    header("Location: /pages/login.php");
    exit;
}

// Vérifie que l'ID est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID d'annonce invalide.";
    header("Location: /index.php");
    exit;
}

$id = (int) $_GET['id'];
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Vérifie si l'annonce existe
$sql = "SELECT * FROM listing WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$annonce = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$annonce) {
    $_SESSION['error'] = "Annonce introuvable.";
    header("Location: /index.php");
    exit;
}

// Vérifie si l'utilisateur peut supprimer : admin OU créateur (agent autorisé à supprimer ses propres annonces)
if ($role !== 'admin' && $annonce['user_id'] != $userId) {
    $_SESSION['error'] = "Vous n'avez pas le droit de supprimer cette annonce.";
    header("Location: /index.php");
    exit;
}


// Suppression
$deleteSql = "DELETE FROM listing WHERE id = ?";
$deleteStmt = $pdo->prepare($deleteSql);
$deleteStmt->execute([$id]);

$_SESSION['success'] = "Annonce supprimée avec succès.";
header("Location: /index.php");
exit;
