<div class="reward-details">
    <?php if ($reward['image_filename']) : ?>
        <img src="/upload/<?= ($reward['image_filename']) ?>" alt="<?= ($reward['title']) ?>" width="300">
    <?php endif; ?>
    <h1><?= ($reward['title']) ?></h1>
    <p><strong>Description :</strong> <?= ($reward['description']) ?></p>
    <p><strong>Prix :</strong> <?= ($reward['reward_price']) ?> points</p>
    <p><strong>Quantité Disponible :</strong> <?= ($reward['quantity_available']) ?></p>
    <p><strong>Proposé par :</strong> <?= ($reward['submitter_name']) ?></p>

    <?php if ($reward['quantity_available'] > 0) : ?>
        <?php if (isset($_SESSION['user']) && hasUserAlreadyRedeemed($_SESSION['user']['id'], $reward['id'], $dbConnection)) : ?>
            <p class="redeemed-text"><strong>Vous avez déjà échangé cette récompense.</strong></p>
        <?php else : ?>
            <!-- Bouton pour échanger les points -->
            <form action="/ctrl/reward/redeem-reward.php" method="POST">
                <input type="hidden" name="idReward" value="<?= ($reward['id']) ?>">
                <button type="submit">Échanger</button>
            </form>
        <?php endif; ?>
    <?php else : ?>
        <p class="unavailable-text"><strong>Cette récompense n'est plus disponible.</strong></p>
    <?php endif; ?>

    <br>
    <a href="/ctrl/reward/rewards.php" class="back-button">Retour</a>
</div>