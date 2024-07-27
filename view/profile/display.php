<h1>Profil de <?= ($user['name']) ?></h1>
 <p>Email: <?= ($user['email']) ?></p>
 <?php if (isset($user['first_name'])) : ?>
     <p>Prénom: <?= ($user['first_name']) ?></p>
 <?php endif; ?>
 <p>Nom: <?= ($user['name']) ?></p>
 <?php if ($association) : ?>
     <h2>Informations sur l'Association</h2>
     <p>Nom de l'association: <?= ($association['name']) ?></p>
     <p>Description: <?= ($association['description']) ?></p>
     <p>Numéro de téléphone: <?= ($association['phone_number']) ?></p>
     <p>Adresse: <?= ($association['address']) ?></p>
     <p>Email de l'association: <?= ($association['email']) ?></p>
 <?php elseif ($partner) : ?>
     <h2>Informations sur l'Entreprise</h2>
     <p>Nom de l'entreprise: <?= ($partner['name']) ?></p>
     <p>Numéro SIRET: <?= ($partner['siret_number']) ?></p>
     <p>Adresse: <?= ($partner['address']) ?></p>
     <p>Email de l'entreprise: <?= ($partner['email']) ?></p>
 <?php else : ?>
     <p>Vous n'avez pas encore enregistré d'entreprise ou d'association.</p>
 <?php endif; ?>
 <a href="/ctrl/login/logout.php">se deconnecter</a>