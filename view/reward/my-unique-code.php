<h1>Mes Codes</h1>

<?php if (!empty($codes)) : ?>
    <div class="codes-list">
        <?php foreach ($codes as $code) : ?>
            <div class="code-item">
                <?php if ($code['image_filename']) : ?>
                    <img 
                        src="/upload/<?= ($code['image_filename']) ?>" 
                        alt="<?= ($code['title']) ?>" 
                        width="200" 
                        class="reward-image <?= ($code['status'] == 'used' || $code['status'] == 'expired') ? 'grayscale' : '' ?>" 
                        data-code="<?= ($code['code']) ?>">
                <?php endif; ?>

                <h2><?= ($code['title']) ?></h2>
                <p><strong>Code unique :</strong> <?= ($code['code']) ?></p> <!-- Affichage du code unique -->
                <p><strong>Statut :</strong> <?= ($code['status']) ?></p>
                <p><strong>Date limite d'utilisation :</strong> <?= ($code['expiration_date']) ?></p>

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