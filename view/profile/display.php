
    <h1>Profil de <?=($user['name']) ?></h1>
    <p>Email: <?=($user['email']) ?></p>
    <?php if (isset($user['first_name'])) : ?>
        <p>Prénom: <?=($user['first_name']) ?></p>
    <?php endif; ?>
    <p>Nom: <?=($user['name']) ?></p>
    
    <?php if ($association) : ?>
        <h2>Informations sur l'Association</h2>
        <p>Nom de l'association: <?=($association['name']) ?></p>
        <p>Description: <?=($association['description']) ?></p>
        <p>Numéro de téléphone: <?=($association['phone_number']) ?></p>
        <p>Adresse: <?=($association['address']) ?></p>
        <p>Email de l'association: <?=($association['email']) ?></p>
        <p>Statut: <?=($association['status']) ?></p>
        <?php if ($association['status'] == 'pending') : ?>
            <p>Votre association est en attente d'acceptation.</p>
        <?php elseif ($association['status'] == 'approved') : ?>
            <p>Votre association a été acceptée.</p>
        <?php elseif ($association['status'] == 'rejected') : ?>
            <p>Votre association a été rejetée. Raison: <?=getRejectionReason($association['id'], 'association', $dbConnection) ?></p>
        <?php endif; ?>
    
        <?php elseif ($partner) : ?>
        <h2>Informations sur l'Entreprise</h2>
        <p>Nom de l'entreprise: <?=($partner['name']) ?></p>
        <p>Numéro SIRET: <?=($partner['siret_number']) ?></p>
        <p>Adresse: <?=($partner['address']) ?></p>
        <p>Email de l'entreprise: <?=($partner['email']) ?></p>
        <p>Statut: <?=($partner['status']) ?></p>
        <?php if ($partner['status'] == 'pending') : ?>
            <p>Votre entreprise est en attente d'acceptation.</p>
        <?php elseif ($partner['status'] == 'approved') : ?>
            <p>Votre entreprise a été acceptée.</p>
        <?php elseif ($partner['status'] == 'rejected') : ?>
            <p>Votre entreprise a été rejetée. Raison: <?=getRejectionReason($partner['id'], 'partner', $dbConnection) ?></p>
        <?php endif; ?>
    
        <?php else : ?>
        <p>Vous n'avez pas encore enregistré d'entreprise ou d'association.</p>
    <?php endif; ?>

<a href="/ctrl/login/logout.php">se deconnecter</a>