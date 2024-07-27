<h1>Profil de <?= ($user['name']) ?></h1>
<p>Email: <?= ($user['email']) ?></p>
<?php if (isset($user['first_name'])) : ?>
    <p>Prénom: <?= ($user['first_name']) ?></p>
<?php endif; ?>
<p>Nom: <?= ($user['name']) ?></p>

<?php if ($association && is_array($association)) : ?>
    <h2>Informations sur l'Association</h2>
    <p>Nom de l'association: <?= ($association['name']) ?></p>
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
        <p>Votre association a été rejetée. Raison: <?=getRejectionReason($association['id'], 'association', $dbConnection) ?></p>
    <?php endif; ?>
<?php endif; ?>

<?php if ($partner && is_array($partner)) : ?>
    <h2>Informations sur l'Entreprise</h2>
    <p>Nom de l'entreprise: <?= ($partner['name']) ?></p>
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
<?php endif; ?>

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
<a href="/ctrl/login/logout.php">Se déconnecter</a>