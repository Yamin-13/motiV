   <h2>Ajouter un Établissement Scolaire</h2>
   <?php if (isset($_SESSION['error'])) : ?>
       <div class="error-message">
           <?= $_SESSION['error'] ?>
           <?php unset($_SESSION['error']); ?>
       </div>
   <?php endif; ?>
   <form action="/ctrl/educational-establishment/add.php" method="post">
       <label for="name">Nom de l'établissement :</label>
       <input type="text" id="name" name="name" required><br>

       <label for="email">Email de l'établissement :</label>
       <input type="email" id="email" name="email" required><br>

       <label for="phone_number">Numéro de téléphone :</label>
       <input type="text" id="phone_number" name="phone_number" required><br>

       <label for="address">Adresse :</label>
       <input type="text" id="address" name="address" required><br>

       <label for="RNE_number">Numéro RNE :</label>
       <input type="text" id="RNE_number" name="RNE_number" required><br>

       <button type="submit">Ajouter l'établissement</button>
   </form>