<main class="main-content">
    <h1 class="myUnique-code-title">Mes Codes</h1>

    <?php if (!empty($codes)) : ?>
        <section class="myUnique-code-list">
            <?php foreach ($codes as $code) : ?>
                <article class="myUnique-code-item">
                    <!-- Image de la récompense clickable pour ouvrir le QR code en modal -->
                    <?php if ($code['image_filename']) : ?>
                        <img
                            src="/upload/<?= ($code['image_filename']) ?>"
                            alt="<?= ($code['title']) ?>"
                            class="reward-image myUnique-code-img <?= ($code['status'] == 'used' || $code['status'] == 'expired') ? 'grayscale' : '' ?>"
                            data-code="<?= ($code['code']) ?>">
                    <?php endif; ?>

                    <h2 class="myUnique-code-title"><?= ($code['title']) ?></h2>
                    <p class="myUnique-code-info"><strong>Code unique :</strong> <?= ($code['code']) ?></p>
                    <p class="myUnique-code-info"><strong>Statut :</strong> <?= getFrenchStatus($code['status'], $code['used_at']) ?></p>

                    <!-- Date limite d'utilisation -->
                    <?php if (!empty($code['start_date_usage'])) : ?>
                        <p class="myUnique-code-info"><strong>Date de début d'utilisation :</strong> <?= date('d/m/Y', strtotime($code['start_date_usage'])) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($code['reward_expiration'])) : ?>
                        <p class="myUnique-code-info"><strong>Date d'expiration du code :</strong> <?= date('d/m/Y', strtotime($code['reward_expiration'])) ?></p>
                    <?php else : ?>
                        <!-- Calcule la date d'échange + 6 mois si aucune date d'expiration n'est fournie -->
                        <?php
                        $expirationDefault = date('d/m/Y', strtotime($code['generated_at'] . ' + 6 months'));
                        ?>
                        <p class="myUnique-code-info"><strong>Date limite d'utilisation du code :</strong> <?= $expirationDefault ?></p>
                    <?php endif; ?>

                    <!-- QR Code caché affiché dans le modal -->
                    <div id="qrModal-<?= ($code['code']) ?>" class="qr-modal">
                        <div class="modal-content" data-code="<?= ($code['code']) ?>">
                            <img src="<?= generateQRCodeUrl($code['code']) ?>" alt="QR Code" width="300">
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    <?php else : ?>
        <p class="myUnique-code-empty">Vous n'avez échangé aucun code pour l'instant.</p>
    <?php endif; ?>
</main>