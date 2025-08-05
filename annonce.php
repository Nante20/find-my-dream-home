<div class="annonce">
    <img src="<?= $item['image'] ?>" alt="<?= $item['titre'] ?>">
    <h3><?= $item['titre'] ?></h3>
    <p class="prix"><?= number_format($item['prix'], 0, ',', ' ') ?> €</p>
    <p><strong>Ville :</strong> <?= $item['ville'] ?></p>
    <p><?= $item['description'] ?></p>
    <p class="type"><?= $item['type'] ?></p>
    <button>Contact</button>
</div>
