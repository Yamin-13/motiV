<form action="/ctrl/young/update-profile-process.php" method="POST" enctype="multipart/form-data">
    <div>
        <label for="first_name">Prénom :</label>
        <input type="text" name="first_name" id="first_name" class="form-control" required>
    </div>
    <div>
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div>
        <label for="date_of_birth">Date de Naissance :</label>
        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" required>
    </div>
    <div>
        <label for="address">Adresse :</label>
        <input type="text" name="address" id="address" class="form-control" required>
    </div>
    <div>
        <label for="ine_number">Numéro INE :</label>
        <input type="text" name="ine_number" id="ine_number" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Mettre à jour</button>
</form>