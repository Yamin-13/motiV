<h1>Détails de l'Entreprise</h1>
    <p>ID: <?=($partner['id']) ?></p>
    <p>Nom: <?=($partner['name']) ?></p>
    <p>Email: <?=($partner['email']) ?></p>
    <p>SIRET: <?=($partner['siret_number']) ?></p>
    <p>Adresse: <?=($partner['address']) ?></p>
    <p>Statut: <?=($partner['status']) ?></p>
    <h2>Propriétaire</h2>
    <p>Nom: <?=($owner['name']) ?></p>
    <p>Prénom: <?=($owner['first_name']) ?></p>
    <p>Email: <?=($owner['email']) ?></p>
    
    <h2>Envoyer un message au propriétaire</h2>
    <form action="/ctrl/admin/send-message.php" method="POST">
        <input type="hidden" name="user_id" value="<?=($owner['id']) ?>">
        <label for="subject">Sujet:</label>
        <input type="text" id="subject" name="subject" required><br>
        <label for="body">Message:</label>
        <textarea id="body" name="body" required></textarea><br>
        <button type="submit">Envoyer le message</button>
    </form>

    <a href="/ctrl/admin/partner-delete.php?id=<?=($partner['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
        <button>Supprimer l'Entreprise</button>
    </a>