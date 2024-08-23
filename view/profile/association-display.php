<h1>Profil de <?= ($user['first_name'] . ' ' . $user['name']) ?></h1>
<p><img src="/upload/<?= ($_SESSION['user']['avatar_filename'] ?? 'default-avatar.png') ?>" alt="Avatar de l'utilisateur"></p>
<p>Email: <?= ($user['email']) ?></p>
<p>Prénom: <?= ($user['first_name']) ?></p>
<p>Nom: <?= ($user['name']) ?></p>

<?php if ($association && is_array($association)) : ?>
    <h2>Informations sur l'Association</h2>
    <p>Nom de l'association: <?= ($association['name']) ?></p>
    <p>Président: <?= ($association['president_first_name'] . ' ' . $association['president_name']) ?></p>
    <p>Description: <?= ($association['description']) ?></p>
    <p>Numéro de téléphone: <?= ($association['phone_number']) ?></p>
    <p>Adresse: <?= ($association['address']) ?></p>
    <p>Email de l'association: <?= ($association['email']) ?></p>
    <p>Statut: <?= ($association['status']) ?></p>
    <?php if ($association['status'] == 'pending') : ?>
        <p>Votre association est en attente d'acceptation.</p>
    <?php elseif ($association['status'] == 'approved') : ?>
        <p>Votre association a été acceptée.</p>
    <?php elseif ($association['status'] == 'rejected') : ?>
        <p>Votre association a été rejetée. Raison: <?= (getRejectionReason($association['id'], 'association', $dbConnection)) ?></p>
    <?php endif; ?>
    <?php if ($user['idRole'] == 50) : ?>
        <a href="/ctrl/association/delete.php?id=<?= $association['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette association ?');">
            <button>Supprimer l'Association</button>
        </a>
        <a href="/ctrl/association/update-display.php?id=<?= $association['id'] ?>"><button>Modifier l'Association</button></a>
        <a href="/ctrl/invitation/send-invitation-form.php?entity_type=association&entity_id=<?= $association['id'] ?>"><button>Inviter un Membre</button></a>
    <?php endif; ?>

    <?php if (is_array($members) && count($members) > 0) : ?>
        <h2>Liste des membres</h2>
        <ul>
            <?php foreach ($members as $member) : ?>
                <li>
                    <?= ($member['first_name'] . ' ' . $member['name'] . ' (' . $member['email'] . ')') ?>
                    <?php if ($user['idRole'] == 50) : ?>
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
<a href="/ctrl//mission/add-mission-display.php">Ajouter une mission</a>
<a href="/ctrl/mission/mission-list.php">Liste des missions</a>
<?php if (($association && is_array($association) && $association['status'] == 'rejected' && $user['idRole'] == 50) || (!$association && $user['idRole'] == 50)) : ?>
    <h2>Ajouter une Nouvelle Association</h2>
    <form action="/ctrl/association/add-association.php" method="POST">
        <label for="association_name">Nom de l'Association:</label>
        <input type="text" id="association_name" name="association_name" required><br>
        <label for="association_email">Email de l'Association:</label>
        <input type="email" id="association_email" name="association_email" required><br>
        <label for="association_rne">Numéro RNE:</label>
        <input type="text" id="association_rne" name="association_rne" required><br>
        <label for="association_address">Adresse:</label>
        <input type="text" id="association_address" name="association_address" required><br>
        <button type="submit">Ajouter l'Association</button>
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
            <label for="avatar">Nouveau Avatar :</label>
            <input type="file" id="avatar" name="avatar">
        </div>
        <div>
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" id="password" name="password">
        </div>
        <div>
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>
        <button type="submit" class="update-button">Mettre à jour</button>
    </form>
</section>

<?php if ($mission && $young): ?>
    <form action="/ctrl/association/mark-absent.php" method="POST">
        <input type="hidden" name="idMission" value="<?= $mission['id'] ?>">
        <input type="hidden" name="idUser" value="<?= $young['id'] ?>">
        <label for="reason">Raison:</label>
        <input type="text" name="reason" required>
        <button type="submit">Marquer comme absent</button>
    </form>
<?php else: ?>
    <p>Impossible d'afficher le formulaire : mission ou utilisateur introuvable.</p>
<?php endif; ?>

<a href="/ctrl/login/logout.php">Se déconnecter</a>