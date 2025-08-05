<?php
require 'data.php';
include 'header.php';
?>
<div class="container">

    <!-- Maisons -->
    <h2>Nos annonces de maison</h2>
    <div class="annonces">
        <?php foreach ($maisons as $item): ?>
            <?php include 'annonce.php'; ?>
        <?php endforeach; ?>
    </div>

    <!-- Appartements -->
    <h2>Nos annonces d'appartements</h2>
    <div class="annonces">
        <?php foreach ($appartements as $item): ?>
            <?php include 'annonce.php'; ?>
        <?php endforeach; ?>
    </div>

</div>
<?php include 'footer.php'; ?>
