<?php
require 'data.php';
?>

<?php include 'header.php'; ?>
<div class="container">

    <!-- Maisons -->
    <h2>Nos annonces de maison</h2>
    <div class="annonces">
        <?php foreach ($maisons as $maison): ?>
            <div class="annonce">
                <img src="<?= $maison['image'] ?>" alt="<?= $maison['titre'] ?>">
                <h3><?= $maison['titre'] ?></h3>
                <p class="prix"><?= $maison['prix'] ?></p>
                <p><strong>Ville :</strong> <?= $maison['ville'] ?></p>
                <p><?= $maison['description'] ?></p>
                <p class="type"><?= $maison['type'] ?></p>
                <button>Contact</button>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Appartements -->
    <h2>Nos annonces d'appartements</h2>
    <div class="annonces">
        <?php foreach ($appartements as $appartement): ?>
            <div class="annonce">
                <img src="<?= $appartement['image'] ?>" alt="<?= $appartement['titre'] ?>">
                <h3><?= $appartement['titre'] ?></h3>
                <p class="prix"><?= $appartement['prix'] ?></p>
                <p><strong>Ville :</strong> <?= $appartement['ville'] ?></p>
                <p><?= $appartement['description'] ?></p>
                <p class="type"><?= $appartement['type'] ?></p>
                <button>Contact</button>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php include 'footer.php'; ?>
