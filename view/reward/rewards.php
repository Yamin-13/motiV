<h1>Récompenses Disponibles</h1>

<!-- message -->
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

<?php if ($rewards && count($rewards) > 0) : ?>
    <div class="rewards-list">
        <?php foreach ($rewards as $reward) : ?>
            <div class="reward-item">
                <?php if ($reward['image_filename']) : ?>
                    <img src="/upload/<?= ($reward['image_filename']) ?>" alt="<?= ($reward['title']) ?>" width="200">
                <?php endif; ?>
                <h2><?= ($reward['title']) ?></h2>
                <p><strong>Prix :</strong> <?= ($reward['reward_price']) ?> points</p>
                <p><strong>Quantité Disponible :</strong> <?= ($reward['quantity_available']) ?></p>
                <p><strong>Proposé par :</strong> <?= ($reward['submitter_name']) ?></p>
                <a href="/ctrl/reward/reward-details.php?idReward=<?=($reward['id']) ?>" class="details-button">Détails</a>

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

                <?php if (isset($_SESSION['user']) && ($_SESSION['user']['idRole'] == 10 || $_SESSION['user']['id'] == $reward['idUser'])) : ?>
                    <!-- Bouton pour supprimer la récompense -->
                    <form action="/ctrl/reward/delete-reward.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette récompense ?');">
                        <input type="hidden" name="idReward" value="<?= ($reward['id']) ?>">
                        <button type="submit" class="delete-button">Supprimer</button>
                    </form>
                <?php endif; ?>

                <hr>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>Aucune récompense disponible pour le moment.</p>
<?php endif; ?>