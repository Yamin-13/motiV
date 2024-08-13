<h1>Modifier l'Élève</h1>

<form action="/ctrl/professor/update-student.php" method="POST">
    <input type="hidden" name="id" value="<?= $student['id'] ?>">
    <label for="ine_number">Numéro INE:</label>
    <input type="text" id="ine_number" name="ine_number" value="<?= $student['ine_number'] ?>" required><br>
    <button type="submit">Mettre à jour</button>
</form>