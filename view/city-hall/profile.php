<h1>Profil de <?= ($user['first_name'] . ' ' . $user['name']) ?></h1>
<p><img src="/upload/<?= ($_SESSION['user']['avatar_filename'] ?? 'default-avatar.png') ?>" alt="Avatar de l'utilisateur"></p>
<p>Email: <?= ($user['email']) ?></p>
<p>Prénom: <?= ($user['first_name']) ?></p>
<p>Nom: <?= ($user['name']) ?></p>

<h2>Offres</h2>
<a href="/ctrl/reward/submit-reward.php?idCityHall=<?= $cityHall['id'] ?>">Soumettre une Récompense</a>
<a href="/ctrl/reward/entity-history.php">Voir l'historique des échanges d'offres</a>

<?php if ($cityHall && is_array($cityHall)) : ?>
    <h2>Informations sur la Mairie</h2>
    <p>Nom de la mairie: <?= ($cityHall['name']) ?></p>
    <p>Numéro de téléphone: <?= ($cityHall['phone_number']) ?></p>
    <p>Adresse: <?= ($cityHall['address']) ?></p>
    <p>Email de la mairie: <?= ($cityHall['email']) ?></p>
    <p>Administrateur: <?= ($admin['first_name'] . ' ' . $admin['name']) ?></p>

    <?php if ($user['idRole'] == 30) : ?>
        <a href="/ctrl/city-hall/update-display.php?id=<?= ($cityHall['id']) ?>"><button>Modifier la Mairie</button></a>
        <a href="/ctrl/invitation/send-invitation-form.php?entity_type=city-hall&entity_id=<?= ($cityHall['id']) ?>"><button>Inviter un Membre</button></a>
    <?php endif; ?>

    <?php if (is_array($members) && count($members) > 0) : ?>
        <h2>Liste des membres</h2>
        <ul>
            <?php foreach ($members as $member) : ?>
                <li>
                    <?= ($member['first_name'] . ' ' . $member['name'] . ' (' . $member['email'] . ')') ?>
                    <?php if (in_array($_SESSION['user']['idRole'], [30])) : ?>
                        <form action="/ctrl/profile/delete-user.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idUser" value="<?= ($member['id']) ?>">
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?');">Supprimer</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?= ($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?= ($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<h2>Messages</h2>
<?php
$messages = getMessagesByidUser($user['id'], $dbConnection);
if ($messages) :
    foreach ($messages as $message) :
?>
        <div>
            <h3><?= ($message['subject']) ?></h3>
            <p><?= ($message['body']) ?></p>
            <small><?= ($message['sent_at']) ?></small>
        </div>
    <?php endforeach; ?>
<?php else : ?>
    <p>Vous n'avez aucun message.</p>
<?php endif; ?>

<section>
    <h2>Mettre à jour le profil</h2>
    <form action="/ctrl/profile/update-user.php" method="post" enctype="multipart/form-data">
        <div>
            <label for="email">Nouvel Email :</label>
            <input type="text" id="email" name="email" value="<?= ($_SESSION['user']['email']) ?>">
        </div>
        <div>
            <label for="name">Nouveau Nom :</label>
            <input type="text" id="name" name="name" value="<?= ($_SESSION['user']['name']) ?>">
        </div>
        <div>
            <label for="first_name">Nouveau Prénom :</label>
            <input type="text" id="first_name" name="first_name" value="<?= ($_SESSION['user']['first_name']) ?>">
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

<a href="/ctrl/login/logout.php">Se déconnecter</a>