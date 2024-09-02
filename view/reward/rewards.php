<h1>Récompenses Disponibles</h1>

<?php if ($rewards && count($rewards) > 0) : ?>
    <div class="rewards-list">
        <?php foreach ($rewards as $reward) : ?>
            <div class="reward-item">
                <?php if ($reward['image_filename']) : ?>
                    <img src="/uploads/rewards/<?= ($reward['image_filename']) ?>" alt="<?= ($reward['title']) ?>" width="200">
                <?php endif; ?>
                <h2><?= ($reward['title']) ?></h2>
                <p><strong>Description :</strong> <?= ($reward['description']) ?></p>
                <p><strong>Prix :</strong> <?= ($reward['reward_price']) ?> points</p>
                <p><strong>Quantité Disponible :</strong> <?= ($reward['quantity_available']) ?></p>
                <p><strong>Proposé par :</strong> <?= ($reward['submitter_name']) ?></p>
                <!-- Bouton pour échanger les points -->
                <form action="/ctrl/reward/redeem-reward.php" method="POST">
                    <input type="hidden" name="idReward" value="<?= ($reward['id']) ?>">
                    <button type="submit">Échanger</button>
                </form>
                <hr>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>Aucune récompense disponible pour le moment.</p>
<?php endif; ?>