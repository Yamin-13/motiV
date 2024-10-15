<h1>Détails de l'utilisateur</h1>
<p>ID: <?= $user['id'] ?></p>
<p>Nom: <?= $user['name'] ?: 'Non spécifié' ?></p>
<p>Prénom: <?= $user['first_name'] ?: 'Non spécifié' ?></p>
<p>Email: <?= $user['email'] ?: 'Non spécifié' ?></p>
<p>Numéro INE: <?= isset($user['ine_number']) ? $user['ine_number'] : 'Non spécifié' ?></p>
<p>Date de naissance: <?= $user['date_of_birth'] ?: 'Non spécifiée' ?></p>
<p>Adresse: <?= $user['address'] ?: 'Non spécifiée' ?></p>
<p>Nombre de points: <?= $user['points'] ?: 'Non spécifié' ?></p>
<p>Date d'inscription: <?= $user['registration_date'] ?: 'Non spécifiée' ?></p>
<p>Dernière connexion: <?= isset($user['last_connexion']) ? $user['last_connexion'] : 'Non spécifiée' ?></p>
<p>Rôle: <?= $user['idRole'] ?></p>


<a href="/ctrl/admin/user-delete.php?id=<?= ($user['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
    <button>Supprimer l'utilisateur</button>
</a>

<h2>Envoyer un message à l'utilisateur</h2>
<form action="/ctrl/admin/send-message.php" method="POST">
    <input type="hidden" name="user_id" value="<?= ($user['id']) ?>">
    <label for="subject">Sujet:</label>
    <input type="text" id="subject" name="subject" required><br>
    <label for="body">Message:</label>
    <textarea id="body" name="body" required></textarea><br>
    <button type="submit">Envoyer le message</button>
</form>
<?php if (isset($_SESSION['success'])) : ?>
    <div class="success-message">
        <?=($_SESSION['success']) ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])) : ?>
    <div class="error-message">
        <?=($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>