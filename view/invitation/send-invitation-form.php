<h2>Inviter un Membre</h2>
<form action="/ctrl/invitation/send-invitation.php" method="POST">
    <input type="hidden" name="entity_type" value="<?= $entityType ?>">
    <input type="hidden" name="entity_id" value="<?= $entityId ?>">
    <label for="email">Email du membre:</label>
    <input type="email" id="email" name="email" required><br>
    <button type="submit">Envoyer l'Invitation</button>
</form>