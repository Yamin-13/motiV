<h1 class="profile-title">Profil de <?= ($user['first_name'] . ' ' . $user['name']) ?></h1>

<section class="profile-avatar-section">
    <figure class="profile-avatar-figure">
        <img class="profile-avatar-img" src="/upload/<?= !empty($user['avatar_filename']) ? $user['avatar_filename'] : '/asset/img/profil-par-defaut.jpeg' ?>" alt="Avatar de <?= ($user['first_name']) ?>">
        <figcaption class="profile-avatar-caption">Email: <span><?= ($user['email']) ?></span></figcaption>
    </figure>
</section>

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

<section class="actions-section">
    <h2 class="section-title">Actions du Partenaire</h2>
    <?php if ($partner['status'] == 'approved') : ?>
        <nav class="actions-nav">
            <ul class="actions-list">
                <li><a class="action-link" href="/ctrl/reward/submit-reward.php?idPartner=<?= $partner['id'] ?>">Soumettre une Récompense</a></li>
                <li><a class="action-link" href="/ctrl/reward/entity-history.php">Mes récompenses proposées</a></li>
            </ul>
        </nav>
    <?php else : ?>
        <p class="alert-message">Votre entreprise doit être validée par un administrateur avant de pouvoir soumettre une récompense.</p>
    <?php endif; ?>
</section>

<section class="messages-received-section">
    <h2 class="section-title">Messages reçus</h2>
    <?php if (!empty($receivedMessages)) : ?>
        <div class="message-list">
            <?php foreach ($receivedMessages as $message) : ?>
                <div class="message-item">
                    <h4 class="message-subject-entity"><?= ($message['subject']) ?></h4>
                    <p class="message-body-entity"><?= nl2br(($message['body'])) ?></p>
                    <small class="message-date-entity"><?= date('d/m/Y H:i', strtotime($message['sent_at'])) ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="alert-message">Vous n'avez reçu aucun message de l'admin.</p>
    <?php endif; ?>
</section>

<?php if ($partner && is_array($partner)) : ?>
    <section class="association-info-section">
        <h2 class="section-title">Informations sur l'Entreprise</h2>
        <p class="association-info"><span>Nom de l'entreprise:</span> <?= ($partner['name']) ?></p>
        <p class="association-info"><span>Chef d'entreprise:</span> <?= ($partner['president_first_name'] . ' ' . $partner['president_name']) ?></p>
        <p class="association-info"><span>Numéro SIRET:</span> <?= ($partner['siret_number']) ?></p>
        <p class="association-info"><span>Adresse:</span> <?= ($partner['address']) ?></p>
        <p class="association-info"><span>Email de l'entreprise:</span> <?= ($partner['email']) ?></p>
        <p class="association-info"><span>Statut:</span> <?= ($partner['status']) ?></p>

        <?php if ($partner['status'] == 'pending') : ?>
            <p class="alert-message">Votre entreprise est en attente d'acceptation.</p>
        <?php elseif ($partner['status'] == 'approved') : ?>
            <p class="alert-message">Votre entreprise a été acceptée.</p>
        <?php elseif ($partner['status'] == 'rejected') : ?>
            <p class="alert-message">Votre entreprise a été rejetée. Raison: <?= (getRejectionReason($partner['id'], 'partner', $dbConnection)) ?></p>
        <?php endif; ?>
    </section>
<?php endif; ?>

<?php if ($user['idRole'] == 40) : ?>
    <section class="admin-section">
        <h2 class="section-title">Administration de l'Entreprise</h2>
        <a href="/ctrl/partner/delete.php?id=<?= $partner['id'] ?>" class="admin-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">Supprimer l'Entreprise</a>
        <a href="/ctrl/partner/update-display.php?id=<?= ($partner['id']) ?>" class="admin-button">Modifier l'Entreprise</a>
        <a href="/ctrl/invitation/send-invitation-form.php?entity_type=partner&entity_id=<?= $partner['id'] ?>" class="admin-button">Inviter un Membre</a>
    </section>
<?php endif; ?>

<?php if (is_array($members) && count($members) > 0) : ?>
    <section class="members-section">
        <h2 class="section-title">Liste des membres</h2>
        <ul class="members-list">
            <?php foreach ($members as $member) : ?>
                <li class="member-item">
                    <?= ($member['first_name'] . ' ' . $member['name'] . ' (' . $member['email'] . ')') ?>
                    <?php if ($user['idRole'] == 40) : ?>
                        <form action="/ctrl/profile/delete-user.php" method="POST" style="display:inline;">
                            <input type="hidden" name="idUser" value="<?= $member['id'] ?>">
                            <button type="submit" class="delete-member-button" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?');">Supprimer</button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>

<section class="messages-sent-section">
    <h2 class="section-title">Vos messages envoyés</h2>
    <?php if (!empty($sentMessages)) : ?>
        <div class="message-list-entity">
            <?php foreach ($sentMessages as $message) : ?>
                <div class="message-item">
                    <h4 class="message-subject-entity"><?= ($message['subject']) ?></h4>
                    <p class="message-body-entity"><?= nl2br(($message['body'])) ?></p>
                    <small>Envoyé le : <?= date('d/m/Y H:i', strtotime($message['sent_at'])) ?></small>
                    <?php if (!empty($message['admin_response'])) : ?>
                        <p><strong>Réponse de l'admin :</strong> <?= nl2br(($message['admin_response'])) ?></p>
                        <small>Répondu le : <?= date('d/m/Y H:i', strtotime($message['response_at'])) ?></small>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="alert-message">Vous n'avez envoyé aucun message à l'admin.</p>
    <?php endif; ?>
</section>

<section class="profile-update-section">
    <h2 class="section-title">Mettre à jour le profil</h2>
    <form action="/ctrl/profile/update-user.php" method="post" enctype="multipart/form-data" class="update-form">
        <div class="form-group-entity">
            <label for="email">Nouvel Email :</label>
            <input type="text" id="email" name="email" value="<?= ($_SESSION['user']['email']) ?>">
        </div>
        <div class="form-group-entity">
            <label for="name">Nouveau Nom :</label>
            <input type="text" id="name" name="name" value="<?= ($_SESSION['user']['name']) ?>">
        </div>
        <div class="form-group-entity">
            <label for="first_name">Nouveau Prénom :</label>
            <input type="text" id="first_name" name="first_name" value="<?= ($_SESSION['user']['first_name']) ?>">
        </div>
        <div class="form-group-entity">
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="form-group-entity">
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>
        <div class="form-group-entity">
            <label for="avatar">Nouvel Avatar :</label>
            <input type="file" id="avatar" name="avatar">
        </div>
        <button type="submit" class="update-button-entity">Mettre à jour</button>
    </form>
</section>

<a href="/ctrl/login/logout.php" class="logout-link-entity">Se déconnecter</a>
