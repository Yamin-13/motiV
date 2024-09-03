<h1>Détails de l'Association</h1>
<p>ID: <?= ($association['id']) ?></p>
<p>Nom: <?= ($association['name']) ?></p>
<p>Email: <?= ($association['email']) ?></p>
<p>Description: <?= ($association['description']) ?></p>
<p>Téléphone: <?= ($association['phone_number']) ?></p>
<p>Adresse: <?= ($association['address']) ?></p>
<p>Statut: <?= ($association['status']) ?></p>
<h2>Président</h2>
<p>Nom: <?= ($president['name']) ?></p>
<p>Prénom: <?= ($president['first_name']) ?></p>
<p>Email: <?= ($president['email']) ?></p>

<form action="/ctrl/admin/update-status.php" method="post" style="display:inline;">
    <input type="hidden" name="type" value="association">
    <input type="hidden" name="id" value="<?= $association['id'] ?>">
    <button type="submit" name="action" value="approve">Accepter</button>
    <a href="/view/admin/reject-reason.php?type=association&id=<?= $association['id'] ?>">Rejeter</a>
</form>

<h2>Envoyer un message au président</h2>
<form action="/ctrl/admin/send-message.php" method="POST">
    <input type="hidden" name="user_id" value="<?= ($president['id']) ?>">
    <label for="subject">Sujet:</label>
    <input type="text" id="subject" name="subject" required><br>
    <label for="body">Message:</label>
    <textarea id="body" name="body" required></textarea><br>
    <button type="submit">Envoyer le message</button>
</form>

<a href="/ctrl/association/delete.php?id=<?= ($association['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette association ?');">
    <button>Supprimer l'Association</button>
</a>