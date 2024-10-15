<section class="profile-section">
    <h3 class="profile-title">Profil de <?= ($_SESSION['user']['first_name']) ?></h3>
    <div class="profile-avatar">
        <img src="/upload/<?= !empty($user['avatar_filename']) ? ($user['avatar_filename']) : '/asset/img/profil-par-defaut.jpeg' ?>" alt="Avatar de l'utilisateur">
    </div>
</section>

<!-- Messages de succès et d'erreur -->
<?php if (isset($_SESSION['success'])) : ?>
    <div class="alert success-message">
        <?= ($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])) : ?>
    <div class="alert error-message">
        <?= ($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<!-- Récompenses -->
<section class="rewards-section">
    <h2>Récompenses</h2>
    <div class="rewards-links">
        <a href="/ctrl/reward/my-unique-code.php" class="reward-link">Mes Récompenses échanger</a>
        <a href="/ctrl/reward/purchase-history.php" class="reward-link">Historique des échanges</a>
    </div>
</section>

<!-- Points Gagnés -->
<section class="points-section">
    <h2>Points Gagnés</h2>
    <?php if ($pointLogs) : ?>
        <ul class="point-logs">
            <?php foreach ($pointLogs as $log) : ?>
                <li class="point-log-item">
                    <span class="log-date"><?= date("d/m/Y", strtotime($log['date_of_grant'])) ?>:</span>
                    Félicitations ! Vous avez reçu <strong><?= intval($log['number_of_points']) ?></strong> points.
                    <span class="log-reason">Raison: <?= ($log['reason']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="no-point-logs">Aucun point gagné pour le moment.</p>
    <?php endif; ?>
</section>

<!-- Missions Acceptées -->
<section class="missions-section">
    <h2>Missions Acceptées</h2>
    <?php
    $acceptedMissions = getAcceptedMissionsByUser($user['id'], $dbConnection);
    if ($acceptedMissions): ?>
        <ul class="missions-list">
            <?php foreach ($acceptedMissions as $mission): ?>
                <li class="mission-item">
                    <div class="mission-info">
                        <strong><?= ($mission['title']) ?></strong>
                        <span class="mission-dates">
                            du <?= date('d/m/Y H:i', strtotime($mission['start_date_mission'])) ?>
                            au <?= date('d/m/Y H:i', strtotime($mission['end_date_mission'])) ?>
                        </span>
                    </div>
                    <a href="/ctrl/mission/unregister-mission.php?id=<?= ($mission['id']) ?>" class="cancel-mission-button">Annuler la Mission</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune mission acceptée.</p>
    <?php endif; ?>
    <a href="/ctrl/young/history-missions.php" class="history-link">Voir l'historique des missions accomplies</a>
</section>

<!-- Messages -->
<section class="messages-section">
    <h2>Messages</h2>
    <?php
    $messages = getMessagesByidUser($user['id'], $dbConnection);
    if ($messages) :
    ?>
        <div class="message-list">
            <?php foreach ($messages as $message) : ?>
                <div class="message-item">
                    <h4 class="message-subject"><?= ($message['subject']) ?></h4>
                    <p class="message-body"><?= nl2br(($message['body'])) ?></p>
                    <small class="message-date"><?= date("d/m/Y H:i", strtotime($message['sent_at'])) ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p class="no-messages">Vous n'avez aucun message.</p>
    <?php endif; ?>
</section>

<!-- Messages Envoyés à l'Admin -->
<section class="sent-messages-section">
    <h2>Vos messages envoyés à l'admin</h2>
    <?php if (!empty($sentMessages)) : ?>
        <div class="message-list">
            <?php foreach ($sentMessages as $message) : ?>
                <div class="message-item">
                    <h4 class="message-subject"><?= ($message['subject']) ?></h4>
                    <p class="message-body"><?= nl2br(($message['body'])) ?></p>
                    <small>Envoyé le : <?= date('d/m/Y H:i', strtotime($message['sent_at'])) ?></small>
                    <?php if (!empty($message['admin_response'])) : ?>
                        <div class="admin-response">
                            <p><strong>Réponse de l'admin :</strong> <?= nl2br(($message['admin_response'])) ?></p>
                            <small>Répondu le : <?= date('d/m/Y H:i', strtotime($message['response_at'])) ?></small>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>Vous n'avez envoyé aucun message à l'admin.</p>
    <?php endif; ?>
</section>

<!-- Messages Reçus de l'Admin -->
<section class="received-messages-section">
    <h2>Messages reçus de l'admin</h2>
    <?php if (!empty($receivedMessages)) : ?>
        <div class="message-list">
            <?php foreach ($receivedMessages as $message) : ?>
                <div class="message-item">
                    <h4 class="message-subject"><?= ($message['subject']) ?></h4>
                    <p class="message-body"><?= nl2br(($message['body'])) ?></p>
                    <small class="message-date"><?= date('d/m/Y H:i', strtotime($message['sent_at'])) ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>Vous n'avez reçu aucun message de l'admin.</p>
    <?php endif; ?>
</section>

<!-- Informations du Profil -->
<section class="profile-info-section">
    <h2>Informations du profil</h2>
    <ul class="profile-info-list">
        <li><strong>Email :</strong> <?= ($_SESSION['user']['email']) ?></li>
        <li><strong>Nom :</strong> <?= ($_SESSION['user']['name']) ?></li>
        <li><strong>Prénom :</strong> <?= ($_SESSION['user']['first_name']) ?></li>
        <li><strong>Date de Naissance :</strong> <?= ($_SESSION['user']['date_of_birth'] ?? 'Non spécifiée') ?></li>
        <li><strong>Adresse :</strong> <?= ($_SESSION['user']['address'] ?? 'Non spécifiée') ?></li>
        <li><strong>Membre depuis le :</strong> <?= date('d/m/Y', strtotime($_SESSION['user']['registration_date'])) ?></li>
        <li><strong>Points :</strong> <?= intval($_SESSION['user']['points'] ?? 0) ?></li>
        <li><strong>Numéro INE :</strong> <?= ($_SESSION['user']['ine_number']) ?></li>
        <li><strong>Dernière connexion :</strong> <?= date('d/m/Y H:i', strtotime($_SESSION['user']['last_connexion'])) ?></li>
    </ul>
</section>

<!-- Mettre à Jour le Profil -->
<section class="update-profile-section">
    <h2>Mettre à jour le profil</h2>
    <form action="/ctrl/login/update.php" method="post" enctype="multipart/form-data" class="update-form">
        <div class="form-group">
            <label for="email">Nouvel Email :</label>
            <input type="email" id="email" name="email" value="<?= ($_SESSION['user']['email']) ?>" >
        </div>
        <div class="form-group">
            <label for="name">Nouveau Nom :</label>
            <input type="text" id="name" name="name" value="<?= ($_SESSION['user']['name']) ?>" >
        </div>
        <div class="form-group">
            <label for="first_name">Nouveau Prénom :</label>
            <input type="text" id="first_name" name="first_name" value="<?= ($_SESSION['user']['first_name']) ?>" >
        </div>
        <div class="form-group">
            <label for="address">Nouvelle Adresse :</label>
            <input type="text" id="address" name="address" value="<?= ($_SESSION['user']['address'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label for="password">Nouveau mot de passe :</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>
        <div class="form-group">
            <label for="avatar">Nouveau Avatar :</label>
            <input type="file" id="avatar" name="avatar" accept="image/*">
        </div>
        <button type="submit" class="update-button">Mettre à jour</button>
    </form>
</section>

<a href="/ctrl/login/logout.php" class="logout-link">Se déconnecter</a>
