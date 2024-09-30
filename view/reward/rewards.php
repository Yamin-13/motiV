<!-- Hero Section -->
<div class="reward-hero">
    <h2>Récompenses Disponibles</h2>
    <p>Échange tes V'points contre des récompenses !</p>
</div>

<!-- Messages -->
<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= $_SESSION['error'] ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<!-- Catégories -->
<h2 class="scroll-reveal">Catégories</h2>
<section class="reward-categories">
    <!-- Toutes les catégories -->
    <div class="reward-category-card scroll-reveal">
        <a href="/ctrl/reward/rewards.php">
            <img src="/asset/img/image-toutes-les-categories.webp" alt="Toutes les catégories">
            <h3>Toutes les catégories</h3>
        </a>
    </div>
    <?php foreach ($categories as $category) : ?>
        <div class="reward-category-card scroll-reveal">
            <a href="/ctrl/reward/rewards.php?category_id=<?= $category['id'] ?>">
                <img src="/asset/img/<?= $category['image_filename'] ?>" alt="<?= $category['name'] ?>">
                <h3><?= $category['name'] ?></h3>
            </a>
        </div>
    <?php endforeach; ?>
</section>

<!-- Récompenses par Catégorie -->
<?php if ($rewards && count($rewards) > 0) : ?>

    <?php
    // Grouper les récompenses par catégorie
    $rewardsByCategory = [];
    foreach ($rewards as $reward) {
        $categoryName = $reward['category_name'];
        $rewardsByCategory[$categoryName][] = $reward;
    }
    ?>

    <?php foreach ($rewardsByCategory as $categoryName => $categoryRewards) : ?>
        <h3 class="scroll-reveal"><?= $categoryName ?></h3>
        <section class="rewards-grid">
            <?php foreach ($categoryRewards as $reward) : ?>
                <?php
                // Vérifie si la récompense est expirée
                $isExpired = !empty($reward['expiration_date']) && strtotime($reward['expiration_date']) < time();
                // Vérifie si la récompense est épuisée
                $isOutOfStock = $reward['quantity_available'] <= 0;
                ?>

                <div class="reward-card scroll-reveal
                    <?php if ($isExpired) echo ' expired'; ?>
                    <?php if ($isOutOfStock) echo ' out-of-stock'; ?>">

                    <?php if ($reward['image_filename']) : ?>
                        <img
                            src="/upload/<?= ($reward['image_filename']) ?>"
                            alt="<?= ($reward['title']) ?>"
                            class="<?php if ($isExpired || $isOutOfStock) echo 'grayscale'; ?>">
                    <?php endif; ?>

                    <h2><?= ($reward['title']) ?></h2>
                    <p><strong>Prix :</strong> <?= ($reward['reward_price']) ?> points</p>
                    <p><strong>Quantité Disponible :</strong> <?= ($reward['quantity_available']) ?></p>
                    <p><strong>Proposé par :</strong> <?= ($reward['submitter_name']) ?></p>
                    <a href="/ctrl/reward/reward-details.php?idReward=<?= ($reward['id']) ?>" class="details-button">Détails</a>

                    <?php if ($isExpired) : ?>
                        <div class="status-badge">Expiré</div>
                        <p class="expired-text">Récompense expirée</p>
                    <?php elseif ($isOutOfStock) : ?>
                        <div class="status-badge">Épuisé</div>
                        <p class="unavailable-text">Cette récompense n'est plus disponible.</p>
                    <?php else : ?>
                        <?php if (isset($_SESSION['user']) && hasUserAlreadyRedeemed($_SESSION['user']['id'], $reward['id'], $dbConnection)) : ?>
                            <p class="redeemed-text">Vous avez déjà échangé cette récompense.</p>
                        <?php else : ?>
                            <?php if (!isset($_SESSION['user']) || $_SESSION['user']['idRole'] == 60) : ?>
                                <!-- Bouton pour échanger les points -->
                                <form action="/ctrl/cart/add-to-cart.php" method="POST">
                                    <input type="hidden" name="idReward" value="<?= ($reward['id']) ?>">
                                    <button type="submit" class="action-button">Ajouter au panier</button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Boutons Admin -->
                    <?php if (isset($_SESSION['user']) && ($_SESSION['user']['idRole'] == 10 || $_SESSION['user']['id'] == $reward['idUser'])) : ?>
                        <div class="admin-buttons">
                            <form action="/ctrl/reward/delete-reward.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette récompense ?');">
                                <input type="hidden" name="idReward" value="<?= ($reward['id']) ?>">
                                <button type="submit" class="delete-button">Supprimer</button>
                            </form>
                            <a href="/ctrl/reward/update-reward.php?id=<?= $reward['id'] ?>" class="edit-button">Modifier</a>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        </section>
    <?php endforeach; ?>

<?php else : ?>
    <p>Aucune récompense disponible pour le moment.</p>
<?php endif; ?>
<script src="/asset/js/reward.js"></script>