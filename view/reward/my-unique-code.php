<h1>Mes Codes</h1>

<?php if (!empty($codes)) : ?>
    <div class="codes-list">
        <?php foreach ($codes as $code) : ?>
            <div class="code-item">
                <!-- Image de la récompense clickable pour ouvrir le QR code en modal -->
                <?php if ($code['image_filename']) : ?>
                    <img
                        src="/upload/<?= ($code['image_filename']) ?>"
                        alt="<?= ($code['title']) ?>"
                        width="200"
                        class="reward-image <?= ($code['status'] == 'used' || $code['status'] == 'expired') ? 'grayscale' : '' ?>"
                        data-code="<?= ($code['code']) ?>">
                <?php endif; ?>

                <h2><?= ($code['title']) ?></h2>
                <p><strong>Code unique :</strong> <?= ($code['code']) ?></p>
                <p><strong>Statut :</strong> <?= getFrenchStatus($code['status'], $code['used_at']) ?></p>

                <!-- Date limite d'utilisation -->

                <?php if (!empty($code['start_date_usage'])) : ?>
                    <p><strong>Date de début d'utilisation :</strong> <?= date('d/m/Y', strtotime($code['start_date_usage'])) ?></p>
                <?php endif; ?>

                <?php if (!empty($code['reward_expiration'])) : ?>
                    <p><strong>Date d'expiration du code :</strong> <?= date('d/m/Y', strtotime($code['reward_expiration'])) ?></p>
                <?php else : ?>
                    <!-- Calcule la date d'échange + 6 mois si aucune date d'expiration n'est fournie -->
                    <?php
                    $expirationDefault = date('d/m/Y', strtotime($code['generated_at'] . ' + 6 months'));
                    ?>
                    <p><strong>Date limite d'utilisation du code :</strong> <?= $expirationDefault ?></p>
                <?php endif; ?>

                <!-- QR Code caché affiché dans le modal -->
                <div id="qrModal-<?= ($code['code']) ?>" class="qr-modal">
                    <div class="modal-content">
                        <span class="close" data-code="<?= ($code['code']) ?>">&times;</span>
                        <img src="<?= generateQRCodeUrl($code['code']) ?>" alt="QR Code" width="300">
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>Vous n'avez échangé aucun code pour l'instant.</p>
<?php endif; ?>
<script src="/asset/js/modal.js"></script>