<h1>Détails de l'Établissement Scolaire</h1>
<p>ID: <?= ($educationalEstablishment['id']) ?></p>
<p>Nom: <?= ($educationalEstablishment['name']) ?></p>
<p>Email: <?= ($educationalEstablishment['email']) ?></p>
<p>Numéro NIE: <?= ($educationalEstablishment['NIE_number']) ?></p>
<p>Numéro de téléphone: <?= ($educationalEstablishment['phone_number']) ?></p>
<p>Adresse: <?= ($educationalEstablishment['address']) ?></p>

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

<a href="/ctrl/educational-establishment/delete.php?id=<?= ($educationalEstablishment['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet établissement scolaire ?');">
    <button>Supprimer l'Établissement</button>
</a>