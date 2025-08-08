<?php
session_start();
require __DIR__ . "/../config/database.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: /pages/login.php");
    exit;
}

// 🔹 Nombre d’annonces par page
$annoncesParPage = 12;

// 🔹 Numéro de page depuis URL (GET), par défaut = 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) $page = 1;

// 🔹 Nombre total d'annonces "Maison"
$totalSql = "SELECT COUNT(*) FROM listing l
             JOIN propertyType p ON l.propertyType_id = p.id
             WHERE p.name = 'Maison'";
$totalAnnonces = $pdo->query($totalSql)->fetchColumn();

// 🔹 Calcul du nombre de pages
$totalPages = ceil($totalAnnonces / $annoncesParPage);

// 🔹 Redirige si la page demandée dépasse la dernière page
if ($page > $totalPages && $totalPages > 0) {
    header("Location: house.php?page=1");
    exit;
}

// 🔹 Calcul de l’OFFSET
$offset = ($page - 1) * $annoncesParPage;

// 🔹 Récupère les annonces de la page actuelle
$sql = "SELECT l.*, p.name as propertyType, t.name as transactionType
        FROM listing l
        JOIN propertyType p ON l.propertyType_id = p.id 
        JOIN transactionType t ON l.transactionType_id = t.id 
        WHERE p.name = 'Maison'
        ORDER BY l.id DESC
        LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':limit', $annoncesParPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . "/../includes/header.php";
?>

<div class="container">
    <h2>Maisons à vendre ou à louer</h2>

    <div class="annonces">
        <?php foreach ($listings as $item): ?>
            <?php include __DIR__ . "/../includes/annonce.php"; ?>
        <?php endforeach; ?>
    </div>

    <!--PAGINATION -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $page): ?>
                <strong><?= $i ?></strong>
            <?php else: ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . "/../includes/footer.php"; ?>


