<?php
session_start();
require __DIR__ . '/../config/database.php';

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Vérifie que l'ID de l'annonce est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID de l'annonce invalide.";
    header("Location: ../index.php");
    exit;
}

$id = (int) $_GET['id'];
$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Récupère l’annonce
$sql = "SELECT * FROM listing WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$annonce = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$annonce) {
    $_SESSION['error'] = "Annonce introuvable.";
    header("Location: ../index.php");
    exit;
}

// Vérifie si l'utilisateur peut modifier (admin OU créateur = agent ou autre)
if ($role !== 'admin' && $annonce['user_id'] != $userId) {
    $_SESSION['error'] = "Vous n'avez pas les droits pour modifier cette annonce.";
    header("Location: ../index.php");
    exit;
}


// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = htmlspecialchars(trim($_POST['titre']));
    $prix = (int) $_POST['prix'];
    $ville = htmlspecialchars(trim($_POST['ville']));
    $description = htmlspecialchars(trim($_POST['description']));
    $image = htmlspecialchars(trim($_POST['image']));
    $type = (int) $_POST['transactionType'];
    $property = (int) $_POST['propertyType'];

    // Mise à jour
    $updateSql = "UPDATE listing SET title = ?, price = ?, city = ?, description = ?, image = ?, transactionType_id = ?, propertyType_id = ? WHERE id = ?";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([$titre, $prix, $ville, $description, $image, $type, $property, $id]);

    $_SESSION['success'] = "Annonce mise à jour avec succès.";
    header("Location: ../index.php");
    exit;
}

// Récupère les types pour les <select>
$types = $pdo->query("SELECT * FROM transactionType")->fetchAll(PDO::FETCH_ASSOC);
$properties = $pdo->query("SELECT * FROM propertyType")->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../includes/header.php';
?>

<div class="container">
    <h1>Modifier l'annonce</h1>

    <form method="post">
        <label>Titre :</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($annonce['title']) ?>" required>

        <label>Prix :</label>
        <input type="number" name="prix" value="<?= $annonce['price'] ?>" required>

        <label>Ville :</label>
        <input type="text" name="ville" value="<?= htmlspecialchars($annonce['city']) ?>" required>

        <label>Description :</label>
        <textarea name="description" required><?= htmlspecialchars($annonce['description']) ?></textarea>

        <label>Image (URL) :</label>
        <input type="text" name="image" value="<?= htmlspecialchars($annonce['image']) ?>" required>

        <label>Type de transaction :</label>
        <select name="transactionType" required>
            <?php foreach ($types as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $t['id'] == $annonce['transactionType_id'] ? 'selected' : '' ?>>
                    <?= $t['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Type de bien :</label>
        <select name="propertyType" required>
            <?php foreach ($properties as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $p['id'] == $annonce['propertyType_id'] ? 'selected' : '' ?>>
                    <?= $p['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Enregistrer les modifications</button>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
