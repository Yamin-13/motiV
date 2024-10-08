<h1>Profil de <?= ($user['first_name'] . ' ' . $user['name']) ?></h1>
<img width = "150px;" src="/upload/<?= !empty($user['avatar_filename']) ? $user['avatar_filename'] : '/asset/img/profil-par-defaut.jpeg' ?>" alt="Avatar de l'utilisateur">
<p>Email: <?= ($user['email']) ?></p>
<p>Prénom: <?= ($user['first_name']) ?></p>
<p>Nom: <?= ($user['name']) ?></p>

<?php if ($educationalEstablishment && is_array($educationalEstablishment)) : ?>
    <h2>Informations sur l'Établissement Scolaire</h2>
    <p>Nom de l'établissement: <?= ($educationalEstablishment['name']) ?></p>
    <p>Numéro RNE: <?= ($educationalEstablishment['RNE_number']) ?></p>
    <p>Code unique de l'établissement : <?= ($educationalEstablishment['unique_code']) ?></p>
    <p>Numéro de téléphone: <?= ($educationalEstablishment['phone_number']) ?></p>
    <p>Adresse: <?= ($educationalEstablishment['address']) ?></p>
    <p>Email de l'établissement: <?= ($educationalEstablishment['email']) ?></p>
    <p>Administrateur: <?= ($educationalEstablishment['admin_first_name'] . ' ' . $educationalEstablishment['admin_name']) ?></p>

    <?php if ($user['idRole'] == 20) : ?>
        <a href="/ctrl/educational-establishment/update-display.php?id=<?= ($educationalEstablishment['id']) ?>"><button>Modifier l'Établissement</button></a>
        <a href="/ctrl/invitation/send-invitation-form.php?entity_type=educational&entity_id=<?= ($educationalEstablishment['id']) ?>"><button>Inviter un Membre</button></a>
    <?php endif; ?>
   
    <?php if ($user['idRole'] == 20): ?>
    <a href="/ctrl/educational-establishment/student-list.php"><button>Listes soumises par les professeurs</button></a>
<?php endif; ?>
<a href="/ctrl/educational-establishment/list-young.php"><button>Listes des élèves inscris</button></a>

    <?php if (is_array($members) && count($members) > 0) : ?>
        <h2>Liste des membres</h2>
        <ul>
            <?php foreach ($members as $member) : ?>
                <li>
                    <?= ($member['first_name'] . ' ' . $member['name'] . ' (' . $member['email'] . ')') ?>
                    <?php if (in_array($_SESSION['user']['idRole'], [20])) : ?>
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

<h2>Vos messages envoyés à l'admin</h2>
<?php if (!empty($sentMessages)) : ?>
    <div class="message-list">
        <?php foreach ($sentMessages as $message) : ?>
            <div class="message-item">
                <h4><?= ($message['subject']) ?></h4>
                <p><?= nl2br(($message['body'])) ?></p>
                <small>Envoyé le : <?= date('d/m/Y H:i', strtotime($message['sent_at'])) ?></small>
                <?php if (!empty($message['admin_response'])) : ?>
                    <p><strong>Réponse de l'admin :</strong> <?= nl2br(($message['admin_response'])) ?></p>
                    <small>Répondu le : <?= date('d/m/Y H:i', strtotime($message['response_at'])) ?></small>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>Vous n'avez envoyé aucun message à l'admin.</p>
<?php endif; ?>

<h2>Messages reçus de l'admin</h2>
<?php if (!empty($receivedMessages)) : ?>
    <div class="message-list">
        <?php foreach ($receivedMessages as $message) : ?>
            <div class="message-item">
                <h4><?= ($message['subject']) ?></h4>
                <p><?= nl2br(($message['body'])) ?></p>
                <small class="message-date"><?= date('d/m/Y H:i', strtotime($message['sent_at'])) ?></small>
            </div>
        <?php endforeach; ?>
    </div>
<?php else : ?>
    <p>Vous n'avez reçu aucun message de l'admin.</p>
<?php endif; ?>

<a href="/ctrl/login/logout.php">Se déconnecter</a>