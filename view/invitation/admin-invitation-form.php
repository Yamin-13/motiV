<h2>Inviter un établissement scolaire ou une mairie</h2>

<!-- Messages -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="success-message">
        <?= $_SESSION['success'] ?>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="error-message">
        <?= $_SESSION['error'] ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<form action="/ctrl/invitation/admin-send-invitation.php" method="post">
    <label for="email">Email de l'invité :</label>
    <input type="email" id="email" name="email" required><br>
    
    <label for="role">Type d'invitation :</label>
    <select id="role" name="role" required>
        <option value="20">Établissement Scolaire</option>
        <option value="30">Mairie</option>
    </select><br>
    
    <button type="submit">Envoyer l'invitation</button>
</form>
