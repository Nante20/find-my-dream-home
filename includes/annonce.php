<div class="annonce">
    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
    <h3><?= htmlspecialchars($item['title']) ?></h3>
    <p class="prix"><?= number_format((float)$item['price'], 0, ',', ' ') ?> €</p>
    <p><strong>Ville :</strong> <?= htmlspecialchars($item['city']) ?></p>
    <p><?= htmlspecialchars($item['description']) ?></p>
    <p class="type"><?= htmlspecialchars($item['transactionType']) ?></p>
    <p class="propertyType"><?= htmlspecialchars($item['propertyType']) ?></p>
    <button>Contact</button>
</div>

