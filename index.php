<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /pages/login.php");
    exit;
}

require __DIR__ . '/config/database.php';

// Récupération des annonces avec jointures
$sql = "
    SELECT 
        l.id,
        l.title,
        l.price,
        l.city,
        l.description,
        l.image,
        l.user_id,
        p.name AS propertyType,
        t.name AS transactionType
    FROM listing l
    JOIN propertyType p ON l.propertyType_id = p.id
    JOIN transactionType t ON l.transactionType_id = t.id
    ORDER BY l.id DESC
";


$stmt = $pdo->query($sql);
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/includes/header.php';
?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="error">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="container">
    <h2>Nos annonces</h2>

    <div class="annonces">
        <?php foreach ($listings as $item): ?>
            <?php include __DIR__ . '/includes/annonce.php'; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
