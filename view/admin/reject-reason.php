<h1>Raison du Rejet</h1>
    <form action="/ctrl/admin/reject-reason.php" method="post">
        <input type="hidden" name="type" value="<?= htmlspecialchars($_GET['type']) ?>">
        <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
        <label for="reason">Raison:</label>
        <textarea id="reason" name="reason" required></textarea><br>
        <button type="submit">Soumettre</button>
    </form>