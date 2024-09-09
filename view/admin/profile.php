<h2 class="secret-message">Bonjour, Admininistrateur <?= ($_SESSION['user']['name']) ?>.</h2>
<ul class="admin-actions">
    <li><a class="header-link" href="">Option</a></li>
</ul>
<a href="/ctrl/login/logout.php">se deconnecter</a>

<!-- message de confirmation (entité accepté ou refusé) -->
<?php
if (isset($_SESSION['message'])) {
    echo '<p>' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
}?>

<h2>Entreprises en attente</h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Adresse</th>
        <th>Numéro SIRET</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($pendingPartners as $partner) : ?>
        <tr>
            <td><?= ($partner['name']) ?></td>
            <td><?= ($partner['address']) ?></td>
            <td><?= ($partner['siret_number']) ?></td>
            <td>
                <form action="/ctrl/admin/update-status.php" method="post" style="display:inline;">
                    <input type="hidden" name="type" value="partner">
                    <input type="hidden" name="id" value="<?= $partner['id'] ?>">
                    <button type="submit" name="action" value="approve">Accepter</button>
                    <a href="/view/admin/reject-reason.php?type=partner&id=<?= $partner['id'] ?>">Rejeter</a>
                </form>
                <!-- Bouton Détails -->
                <a href="/ctrl/partner/details.php?id=<?= $partner['id'] ?>">Détails</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Associations en attente</h2>
<table>
    <tr>
        <th>Nom</th>
        <th>Email</th>
        <th>Numéro RNE</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($pendingAssociations as $association) : ?>
        <tr>
            <td><?= ($association['name']) ?></td>
            <td><?= ($association['email']) ?></td>
            <td><?= ($association['RNE_number']) ?></td>
            <td>
                <form action="/ctrl/admin/update-status.php" method="post" style="display:inline;">
                    <input type="hidden" name="type" value="association">
                    <input type="hidden" name="id" value="<?= $association['id'] ?>">
                    <button type="submit" name="action" value="approve">Accepter</button>
                    <a href="/view/admin/reject-reason.php?type=association&id=<?= $association['id'] ?>">Rejeter</a>
                </form>
                <!-- Bouton Détails -->
                <a href="/ctrl/association/details.php?id=<?= $association['id'] ?>">Détails</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="/ctrl/association/list.php">Liste des associations</a><br>
<a href="/ctrl/partner/list.php">Liste des partenaires</a><br>
<a href="/ctrl/admin/list.php">Liste des utilisateurs</a><br>
<a href="/ctrl/city-hall/list.php">Liste des Mairies</a><br>
<a href="/ctrl/educational-establishment/list.php">Liste des Etablissements Scolaires</a><br>
<a href="/ctrl//invitation/admin-invitation-form.php">Inviter une Mairie ou un établissement scolaire</a>

<h2>Gestion des Missions</h2>
<ul>
    <li><a href="/ctrl/admin/admin-mission-list.php">Missions en cours</a></li>
    <li><a href="/ctrl/admin/admin-mission-history.php">Historique des missions</a></li>
    <a href="/ctrl/admin/bareme-points.php">Modifier le barème des points</a>
</ul>

<h2>Gestion des Récompenses</h2>
<a href="/ctrl/admin/transaction-list.php">Voir les Transactions</a>

<h2>Gestion des élèves</h2>
<a href="/ctrl/admin/student-list-admin.php">Voir la liste des élèves validés</a>

<h2>Messages reçus</h2>
<?php if (!empty($messages)) : ?>
    <table>
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
                    <td><?= ($message['first_name'] . ' ' . $message['name']) ?></td>
                    <td><?= ($message['entity_type']) ?></td> 
                    <td><?= ($message['entity_name']) ?></td> 
                    <td><?= ($message['subject']) ?></td>
                    <td><?= nl2br(($message['body'])) ?></td>
                    <td>
                        <form action="/ctrl/contact/reply-message.php" method="POST">
                            <input type="hidden" name="message_id" value="<?= ($message['id']) ?>">
                            <textarea name="admin_response" rows="4"></textarea><br>
                            <button type="submit">Répondre</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucun message reçu pour le moment.</p>
<?php endif; ?>