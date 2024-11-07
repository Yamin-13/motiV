<h1 class="profile-admin-title">Bonjour, Administrateur <?= ($_SESSION['user']['name']) ?>.</h1>

<!-- Message de confirmation (entité acceptée ou refusée) -->
<?php if (isset($_SESSION['message'])) : ?>
    <p class="profile-admin-message"><?= $_SESSION['message'] ?></p>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<!-- Section des entreprises en attente -->
<section class="profile-admin-section">
    <h2 class="profile-admin-section-title">Entreprises en attente</h2>
    <table class="profile-admin-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Numéro SIRET</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendingPartners as $partner) : ?>
                <tr>
                    <td><?= $partner['name'] ?></td>
                    <td><?= $partner['address'] ?></td>
                    <td><?= $partner['siret_number'] ?></td>
                    <td>
                        <div class="profile-admin-actions">
                            <form action="/ctrl/admin/update-status.php" method="post" class="profile-admin-actions-form">
                                <input type="hidden" name="type" value="partner">
                                <input type="hidden" name="id" value="<?= $partner['id'] ?>">
                                <button type="submit" name="action" value="approve" class="profile-admin-btn profile-admin-approve-btn">Accepter</button>
                            </form>
                            <a href="/view/admin/reject-reason.php?type=partner&id=<?= $partner['id'] ?>" class="profile-admin-btn profile-admin-reject-link">Rejeter</a>
                            <a href="/ctrl/partner/details.php?id=<?= $partner['id'] ?>" class="profile-admin-btn profile-admin-details-link">Détails</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<!-- Section des associations en attente -->
<section class="profile-admin-section">
    <h2 class="profile-admin-section-title">Associations en attente</h2>
    <table class="profile-admin-table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Numéro RNE</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendingAssociations as $association) : ?>
                <tr>
                    <td><?= $association['name'] ?></td>
                    <td><?= $association['email'] ?></td>
                    <td><?= $association['RNE_number'] ?></td>
                    <!-- Actions -->
                    <td>
                        <div class="profile-admin-actions">
                            <form action="/ctrl/admin/update-status.php" method="post" class="profile-admin-actions-form">
                                <input type="hidden" name="type" value="partner">
                                <input type="hidden" name="id" value="<?= $partner['id'] ?>">
                                <button type="submit" name="action" value="approve" class="profile-admin-btn profile-admin-approve-btn">Accepter</button>
                                <a href="/view/admin/reject-reason.php?type=partner&id=<?= $partner['id'] ?>" class="profile-admin-btn profile-admin-reject-link">Rejeter</a>
                            </form>
                            <a href="/ctrl/partner/details.php?id=<?= $partner['id'] ?>" class="profile-admin-btn profile-admin-details-link">Détails</a>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<!-- Section gestion des entités -->
<section class="profile-admin-section">
    <h2 class="profile-admin-section-title">Gestion des entités</h2>
    <ul class="profile-admin-list">
        <li><a href="/ctrl/association/list.php" class="profile-admin-list-link">Liste des associations</a></li>
        <li><a href="/ctrl/partner/list.php" class="profile-admin-list-link">Liste des partenaires</a></li>
        <li><a href="/ctrl/admin/list.php" class="profile-admin-list-link">Liste des utilisateurs</a></li>
        <li><a href="/ctrl/city-hall/list.php" class="profile-admin-list-link">Liste des Mairies</a></li>
        <li><a href="/ctrl/educational-establishment/list.php" class="profile-admin-list-link">Liste des Établissements Scolaires</a></li>
        <li><a href="/ctrl//invitation/admin-invitation-form.php" class="profile-admin-list-link">Inviter une Mairie ou un Établissement Scolaire</a></li>
    </ul>
</section>

<!-- Section gestion des missions -->
<section class="profile-admin-section">
    <h2 class="profile-admin-section-title">Gestion des Missions</h2>
    <ul class="profile-admin-list">
        <li><a href="/ctrl/admin/admin-mission-list.php" class="profile-admin-list-link">Missions en cours</a></li>
        <li><a href="/ctrl/admin/admin-mission-history.php" class="profile-admin-list-link">Historique des missions</a></li>
        <li><a href="/ctrl/admin/bareme-points.php" class="profile-admin-list-link">Modifier le barème des points</a></li>
    </ul>
</section>

<!-- Section gestion des récompenses -->
<section class="profile-admin-section">
    <h2 class="profile-admin-section-title">Gestion des Récompenses</h2>
    <a href="/ctrl/admin/transaction-list.php" class="profile-admin-list-link">Voir les Transactions</a>
</section>

<!-- Section gestion des élèves -->
<section class="profile-admin-section">
    <h2 class="profile-admin-section-title">Gestion des Élèves</h2>
    <a href="/ctrl/admin/student-list-admin.php" class="profile-admin-list-link">Voir la liste des élèves validés</a>
</section>

<!-- Section des messages reçus -->
<section class="profile-admin-section">
    <h2 class="profile-admin-section-title">Messages reçus</h2>
    <?php if (!empty($messages)) : ?>
        <table class="profile-admin-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Entité</th>
                    <th>Type d'entité</th>
                    <th>Sujet</th>
                    <th>Message</th>
                    <th>Répondre</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message) : ?>
                    <tr>
                        <td><?= $message['first_name'] . ' ' . $message['name'] ?></td>
                        <td><?= $message['entity_type'] ?></td>
                        <td><?= $message['entity_name'] ?></td>
                        <td><?= $message['subject'] ?></td>
                        <td><?= nl2br($message['body']) ?></td>
                        <td>
                            <form action="/ctrl/contact/reply-message.php" method="POST" class="profile-admin-reply-form">
                                <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                <textarea name="admin_response" rows="4" class="profile-admin-textarea"></textarea><br>
                                <button type="submit" class="profile-admin-btn profile-admin-reply-btn">Répondre</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="profile-admin-no-messages">Aucun message reçu pour le moment.</p>
    <?php endif; ?>
</section>

<a href="/ctrl/login/logout.php" class="profile-admin-logout-btn">Se déconnecter</a>