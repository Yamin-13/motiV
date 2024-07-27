<h1>Enregistrement de l'Entreprise</h1>
    <form action="/ctrl/register/register-partner.php" method="POST">
        <input type="hidden" name="user_id" value="<?=($_SESSION['user']['id']) ?>">
        <label for="name">Nom de l'entreprise:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email de l'entreprise:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="siret_number">Numéro SIRET:</label>
        <input type="text" id="siret_number" name="siret_number" required><br>
        <label for="address">Adresse:</label>
        <input type="text" id="address" name="address" required><br>
        <button type="submit">Enregistrer l'entreprise</button>
    </form>
