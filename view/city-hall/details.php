<h1>Détails de la Mairie</h1>
<p>ID: <?= ($cityHall['id']) ?></p>
<p>Nom: <?= ($cityHall['name']) ?></p>
<p>Email: <?= ($cityHall['email']) ?></p>
<p>Numéro de téléphone: <?= ($cityHall['phone_number']) ?></p>
<p>Adresse: <?= ($cityHall['address']) ?></p>

<h2>Administrateur</h2>
<p>Nom: <?= ($admin['name']) ?></p>
<p>Prénom: <?= ($admin['first_name']) ?></p>
<p>Email: <?= ($admin['email']) ?></p>

<h2>Envoyer un message à l'administrateur</h2>
<form action="/ctrl/admin/send-message.php" method="POST">
    <input type="hidden" name="user_id" value="<?= ($admin['id']) ?>">
    <label for="subject">Sujet:</label>
    <input type="text" id="subject" name="subject" required><br>
    <label for="body">Message:</label>
    <textarea id="body" name="body" required></textarea><br>
    <button type="submit">Envoyer le message</button>
</form>

<a href="/ctrl/city-hall/delete.php?id=<?= ($cityHall['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette mairie ?');">
    <button>Supprimer la Mairie</button>
</a>