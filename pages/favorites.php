<?php
session_start();
require __DIR__ . '/../config/database.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT l.*, p.name AS propertyType, t.name AS transactionType
    FROM listing l
    JOIN propertyType p ON l.propertyType_id = p.id
    JOIN transactionType t ON l.transactionType_id = t.id
    JOIN favorite f ON l.id = f.listing_id
    WHERE f.user_id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
?>

<div class="container">
    <h1>Mes favoris</h1>
    <div class="annonces">
        <?php foreach ($listings as $item): ?>
            <?php include __DIR__ . '/../includes/annonce.php'; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
