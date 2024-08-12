<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Mairie</title>
</head>
<body>
    <h2>Ajouter une Mairie</h2>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error-message">
            <?= $_SESSION['error'] ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <form action="/ctrl/city-hall/add.php" method="post">
        <label for="name">Nom de la mairie :</label>
        <input type="text" id="name" name="name" required><br>
        
        <label for="email">Email de la mairie :</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="phone_number">Numéro de téléphone :</label>
        <input type="text" id="phone_number" name="phone_number" required><br>
        
        <label for="address">Adresse :</label>
        <input type="text" id="address" name="address" required><br>
        
        <button type="submit">Ajouter la mairie</button>
    </form>
</body>
</html>
