<h1>Inscription Professeur</h1>
<form action="/ctrl/professor/verify-establishment.php" method="POST">
    <label for="rne_number">Numéro RNE de l'Établissement:</label>
    <input type="text" id="rne_number" name="rne_number" required><br>
    <label for="unique_code">Code Unique:</label>
    <input type="text" id="unique_code" name="unique_code" required><br>
    <button type="submit">Vérifier</button>
</form>