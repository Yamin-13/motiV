 <h2>Bienvenue</h2>
 <div>
     <form action="/ctrl/login/register.php" method="post" enctype="multipart/form-data">
         <h2>Inscription</h2>
         <div>
             <input type="text" name="email" placeholder="Email">
         </div>
         <div>
             <input type="password" name="password" placeholder="Mot de Passe">
         </div>
         <div>
             <input type="file" id="file" name="file" onchange="updateFileName()">
             <label for="file" class="inputfile-label-register">Votre avatar</label>
             <span id="file-name">Aucun fichier sélectionné</span>
         </div>
         <button type="submit">Inscription</button>
         <div>
             <p>Déjà Inscrits? <a href="/ctrl/login/login-display.php">S'Identifier</a></p>
         </div>
     </form>
 </div>
 <!-- Messages -->
 <div class="error-message">
     <?php
        // message du formulaire de login ca affiche le contenue de "error"  
        if (isset($_SESSION['error'])) { // isset verifie si ($_SESSION['error']) est pas null
            echo '<p class= "error-message">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']); // unset ca retire ($_SESSION['error']) de la session pour supprimer le message d'érreur de la session
        }

        // message du formulaire d'inscription ca affiche le contenu de "sucess" ou "error"
        if (isset($_SESSION['success'])) { // ca verifie s'il y a le message de succès dans la session
            echo '<p class="messageInscription">' . $_SESSION['success'] . '</p>'; // afiche
            unset($_SESSION['success']); // supprime le message de succès de la session
        } elseif (isset($_SESSION['error'])) { // ca vérifie s'il y a un message d'erreur dans la session
            echo '<p class="error-message">' . $_SESSION['error'] . '</p>'; // affiche
            unset($_SESSION['error']); // supprime le message d'erreur de la session
        }
        ?>
 </div>