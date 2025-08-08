<div class="annonce">
    <img src="/<?= ltrim($item['image'], '/') ?>" alt="<?= htmlspecialchars($item['title']) ?>">

    <h3><?= htmlspecialchars($item['title']) ?></h3>
    <p class="prix"><?= number_format((float)$item['price'], 0, ',', ' ') ?> €</p>
    <p><strong>Ville :</strong> <?= htmlspecialchars($item['city']) ?></p>
    <p><?= htmlspecialchars($item['description']) ?></p>
    <p class="type"><?= htmlspecialchars($item['transactionType']) ?></p>
    <p class="propertyType"><?= htmlspecialchars($item['propertyType']) ?></p>
    <button>Contact</button>

    <!-- Bouton Modifier & Supprimer -->
    <?php if (
        isset($_SESSION['user_id']) &&
        (
            $item['user_id'] == $_SESSION['user_id'] ||
            $_SESSION['role'] === 'admin'
        )
    ): ?>
        <div class="actions">
            <a href="/pages/edit.php?id=<?= $item['id'] ?>" class="btn-edit">Edit</a>
            <a href="/pages/delete.php?id=<?= $item['id'] ?>" class="btn-delete" onclick="return confirm('Do you really want to delete this listing?');">Delete</a>
        </div>
    <?php endif; ?>

    <!-- Bouton Favoris -->
    <?php if (!empty($_SESSION['loggedin'])): ?>
        <form action="/pages/toggle_favorite.php" method="post" style="display:inline;">
            <input type="hidden" name="listing_id" value="<?= $item['id'] ?>">
            <button type="submit" class="btn-fav">
                <?= in_array($item['id'], $_SESSION['favorites'] ?? []) ? "Remove from favorites" : "Add to favorites" ?>
            </button>
        </form>
    <?php endif; ?>
</div>
