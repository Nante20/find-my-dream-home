<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !in_array($_SESSION['role'], ['agent', 'admin'])) {
    $_SESSION['error'] = "Vous n'avez pas l'autorisation d'accéder à cette page.";
    header("Location: /index.php");
    exit;
}

require __DIR__ . '/../config/database.php';
include __DIR__ . '/../includes/header.php';

$transactionTypes = $pdo->query("SELECT * FROM transactionType")->fetchAll(PDO::FETCH_ASSOC);
$propertyTypes = $pdo->query("SELECT * FROM propertyType")->fetchAll(PDO::FETCH_ASSOC);

$erreur = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre = trim($_POST['titre']);
    $prix = (int) $_POST['prix'];
    $ville = trim($_POST['ville']);
    $description = trim($_POST['description']);
    $type = (int) $_POST['type'];
    $property = (int) $_POST['propertyType'];

    // Vérifie l'image
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
        $erreur = "Erreur lors de l'upload de l'image.";
    } else {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 2 * 1024 * 1024; // 2 Mo

        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileSize = $_FILES['image']['size'];
        $fileType = mime_content_type($fileTmpPath);

        if (!in_array($fileType, $allowedTypes)) {
            $erreur = "Seules les images JPG, PNG ou GIF sont autorisées.";
        } elseif ($fileSize > $maxSize) {
            $erreur = "Image trop grande (max 2 Mo).";
        } else {
            $uploadDir = __DIR__ . '/../public/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $targetPath = $uploadDir . $fileName;
            $relativePath = 'public/uploads/' . $fileName;

            if (move_uploaded_file($fileTmpPath, $targetPath)) {
                // Tout est bon, insertion
                $sql = "INSERT INTO listing (title, price, city, description, image, transactionType_id, propertyType_id, user_id)
                        VALUES (:title, :price, :city, :description, :image, :transactionType, :propertyType, :user_id)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'title' => $titre,
                    'price' => $prix,
                    'city' => $ville,
                    'description' => $description,
                    'image' => $relativePath,
                    'transactionType' => $type,
                    'propertyType' => $property,
                    'user_id' => $_SESSION['user_id']
                ]);

                $success = "✅ Annonce ajoutée avec succès !";
            } else {
                $erreur = "Erreur lors de l'enregistrement de l'image.";
            }
        }
    }
}
?>

<div class="container">
    <h1>Ajouter une annonce</h1>

    <?php if (!empty($erreur)): ?>
        <p class="error"><?= $erreur ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?= $success ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Image :</label>
        <input type="file" name="image" accept="image/*" required>

        <label>Titre :</label>
        <input type="text" name="titre" value="<?= isset($titre) ? htmlspecialchars($titre) : '' ?>" required>

        <label>Prix :</label>
        <input type="number" name="prix" value="<?= isset($prix) ? htmlspecialchars($prix) : '' ?>" required>

        <label>Ville :</label>
        <input type="text" name="ville" value="<?= isset($ville) ? htmlspecialchars($ville) : '' ?>" required>

        <label>Description :</label>
        <textarea name="description" required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>

        <label>Type de transaction :</label>
        <select name="type" required>
            <option value="">-- Select --</option>
            <?php foreach ($transactionTypes as $t): ?>
                <option value="<?= $t['id'] ?>" <?= (isset($type) && $type == $t['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Type de bien :</label>
        <select name="propertyType" required>
            <option value="">-- Select --</option>
            <?php foreach ($propertyTypes as $p): ?>
                <option value="<?= $p['id'] ?>" <?= (isset($property) && $property == $p['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Save</button>
    </form>

    <p><a href="/index.php">← Back to home</a></p>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
