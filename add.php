<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <h1>Ajouter une annonce</h1>

<?php
$erreur = "";
$success = "";

// Validation côté serveur
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $image = trim($_POST['image']);
    $titre = trim($_POST['titre']);
    $prix = trim($_POST['prix']);
    $ville = trim($_POST['ville']);
    $description = trim($_POST['description']);
    $type = trim($_POST['type']);
    $propertyType = trim($_POST['propertyType']); 

    if (empty($image) || empty($titre) || empty($prix) || empty($ville) || empty($description) || empty($type) || empty($propertyType)) {
        $erreur = "Veuillez remplir tous les champs.";
    } else {
        $success = "✅ Annonce ajoutée avec succès (pas encore sauvegardée en base).";
    }
}

if (!empty($erreur)) {
    echo "<p class='error'>$erreur</p>";
}
if (!empty($success)) {
    echo "<p class='success'>$success</p>";
}
?>
<div>
    <form id="addForm" method="post">
        <label for="image">URL de l'image :</label>
        <input type="url" id="image" name="image" value="<?= isset($image) ? htmlspecialchars($image) : '' ?>" required>

        <label for="titre">Titre :</label>
        <input type="text" id="titre" name="titre" value="<?= isset($titre) ? htmlspecialchars($titre) : '' ?>" required>

        <label for="prix">Prix :</label>
        <input type="text" id="prix" name="prix" value="<?= isset($prix) ? htmlspecialchars($prix) : '' ?>" required>

        <label for="ville">Ville :</label>
        <input type="text" id="ville" name="ville" value="<?= isset($ville) ? htmlspecialchars($ville) : '' ?>" required>

        <label for="description">Description courte :</label>
        <textarea id="description" name="description" required><?= isset($description) ? htmlspecialchars($description) : '' ?></textarea>

        <label for="type">Type :</label>
        <select id="type" name="type" required>
            <option value="">-- Sélectionner --</option>
            <option value="Rent" <?= (isset($type) && $type === "Rent") ? 'selected' : '' ?>>Rent</option>
            <option value="Sale" <?= (isset($type) && $type === "Sale") ? 'selected' : '' ?>>Sale</option>
        </select>

        <label for="propertyType">propertyType :</label>
        <select id="propertyType" name="propertyType" required>
            <option value="">-- Sélectionner --</option>
            <option value="House" <?= (isset($type) && $type === "House") ? 'selected' : '' ?>>House</option>
            <option value="Appartment" <?= (isset($type) && $type === "Appartment") ? 'selected' : '' ?>>Apartment</option>
        </select>


        <div id="clientError" class="error"></div>

        <button type="submit">Enregistrer</button>
    </form>

    <p><a href="index.php">Retour à l'accueil</a></p>
</div>

<?php include 'footer.php'; ?>
