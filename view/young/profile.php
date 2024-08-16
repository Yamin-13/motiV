<section>
    <h3>Profil de <?= $_SESSION['user']['name'] ?></h3>
    <p><img src="/upload/<?= $_SESSION['user']['avatar_filename'] ?? 'default-avatar.png' ?>" alt="Avatar de l'utilisateur"></p>
</section>
<section>
    <h2>Informations du profil</h2>
    <p><strong>Email :</strong> <?= $_SESSION['user']['email'] ?></p>
    <p><strong>Nom :</strong> <?= $_SESSION['user']['name'] ?></p>
    <p><strong>Prénom :</strong> <?= $_SESSION['user']['first_name'] ?></p>
    <p><strong>Date de Naissance :</strong> <?= $_SESSION['user']['date_of_birth'] ?? 'Non spécifiée' ?></p>
    <p><strong>Adresse :</strong> <?= $_SESSION['user']['address'] ?? 'Non spécifiée' ?></p>
    <p><strong>Membre depuis le :</strong> <?= $_SESSION['user']['registration_date'] ?></p>
    <p><strong>Points :</strong> <?= isset($_SESSION['user']['points']) ? $_SESSION['user']['points'] : 0 ?></p>
    <p><strong>Numéro INE :</strong><?= $_SESSION['user']['ine_number']?></p>
</section>
<section>
    <h2>Mettre à jour le profil</h2>
    <form action="/ctrl/login/update.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="email">Nouvel Email :</label>
            <input type="text" id="email" name="email" value="<?= $_SESSION['user']['email'] ?>">
        </div>
        <div>
            <label for="name">Nouveau Nom :</label>
            <input type="text" id="name" name="name" value="<?= $_SESSION['user']['name'] ?>">
        </div>
        <div>
            <label for="first_name">Nouveau Prénom :</label>
            <input type="text" id="first_name" name="first_name" value="<?= $_SESSION['user']['first_name'] ?>">
        </div>
        <div>
            <label for="address">Nouvelle Adresse :</label>
            <input type="text" id="address" name="address" value="<?= $_SESSION['user']['address'] ?? '' ?>">
        </div>
        <div>
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>
        <div>
            <label for="avatar">Nouveau Avatar :</label>
            <input type="file" id="avatar" name="avatar">
        </div>
        <button type="submit" class="update-button">Mettre à jour</button>
    </form>
</section>
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
<a href="/ctrl/login/logout.php">Se déconnecter</a>