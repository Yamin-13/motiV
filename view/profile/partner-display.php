<h1>Profil de <?= ($user['first_name']) . ' ' . ($user['name']) ?></h1>
<p><img src="/upload/<?= $_SESSION['user']['avatar_filename'] ?? 'default-avatar.png' ?>" alt="Avatar de l'utilisateur"></p>
<p>Email: <?= ($user['email']) ?></p>
<?php if (isset($user['first_name'])) : ?>
    <p>Prénom: <?= ($user['first_name']) ?></p>
<?php endif; ?>
<p>Nom: <?= ($user['name']) ?></p>

<a href="/ctrl/reward/submit-reward.php?idPartner=<?= $partner['id'] ?>">Soumettre une Récompense</a>

<?php if ($partner && is_array($partner)) : ?>
    <h2>Informations sur l'Entreprise</h2>
    <p>Nom de l'entreprise: <?= ($partner['name']) ?></p>
    <p>Chef d'entreprise: <?= ($partner['president_first_name']) . ' ' . ($partner['president_name']) ?></p>
    <p>Numéro SIRET: <?= ($partner['siret_number']) ?></p>
    <p>Adresse: <?= ($partner['address']) ?></p>
    <p>Email de l'entreprise: <?= ($partner['email']) ?></p>
    <p>Statut: <?= ($partner['status']) ?></p>
    <?php if ($partner['status'] == 'pending') : ?>
        <p>Votre entreprise est en attente d'acceptation.</p>
    <?php elseif ($partner['status'] == 'approved') : ?>
        <p>Votre entreprise a été acceptée.</p>
    <?php elseif ($partner['status'] == 'rejected') : ?>
        <p>Votre entreprise a été rejetée. Raison: <?= (getRejectionReason($partner['id'], 'partner', $dbConnection)) ?></p>
    <?php endif; ?>
    <?php if ($user['idRole'] == 40) :
    ?>
        <a href="/ctrl/partner/delete.php?id=<?= $partner['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
            <button>Supprimer l'Entreprise</button>
        </a>
        <a href="/ctrl/partner/update-display.php?id=<?= ($partner['id']) ?>"><button>Modifier l'Entreprise</button></a>
        <a href="/ctrl/invitation/send-invitation-form.php?entity_type=partner&entity_id=<?= $partner['id'] ?>"><button>Inviter un Membre</button></a>
    <?php endif; ?>

    <?php //if ($user['idRole'] == 40 || $user['idRole'] == 45) :?>
    <?php if (is_array($members) && count($members) > 0) : ?>
        <h2>Liste des membres</h2>
        <ul>
            <?php foreach ($members as $member) : ?>
                <li>
                    <?= $member['first_name'] . ' ' . $member['name'] . ' (' . $member['email'] . ')' ?>
                    <?php if ($user['idRole'] == 40) :
                    ?>
                        <form action="/ctrl/profile/delete-user.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idUser" value="<?= $member['id'] ?>">
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?');">Supprimer</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>

<?php if (($partner && is_array($partner) && $partner['status'] == 'rejected' && $user['idRole'] == 40) || (!$partner && $user['idRole'] == 40)) : ?>
    <h2>Ajouter un Nouveau Partenaire</h2>
    <form action="/ctrl/partner/add-partner.php" method="POST">
        <label for="partner_name">Nom du Partenaire:</label>
        <input type="text" id="partner_name" name="partner_name" required><br>
        <label for="partner_email">Email du Partenaire:</label>
        <input type="email" id="partner_email" name="partner_email" required><br>
        <label for="partner_siret">Numéro SIRET:</label>
        <input type="text" id="partner_siret" name="partner_siret" required><br>
        <label for="partner_address">Adresse:</label>
        <input type="text" id="partner_address" name="partner_address" required><br>
        <button type="submit">Ajouter le Partenaire</button>
    </form>
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
    <?php
    endforeach;
else :
    ?>
    <p>Vous n'avez aucun message.</p>
<?php endif; ?>
<section>
    <h2>Mettre à jour le profil</h2>
    <form action="/ctrl/profile/update-user.php" method="post" enctype="multipart/form-data">
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