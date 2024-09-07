   function showEditForm(commentId) {
       // Affiche le formulaire de modification
       document.getElementById('edit-form-' + commentId).style.display = 'block';

       // Cache le lien "Modifier"
       document.getElementById('edit-link-comment-' + commentId).style.display = 'none';
       // Cache le lien "Supprimer"
       document.getElementById('delete-link-comment-' + commentId).style.display = 'none';
   }

   function hideEditForm(commentId) {
       // Cache le formulaire de modification
       document.getElementById('edit-form-' + commentId).style.display = 'none';

       // Réaffiche le lien "Modifier"
       document.getElementById('edit-link-comment-' + commentId).style.display = 'inline';

       // Réaffiche le lien "Supprimer"
       document.getElementById('delete-link-comment-' + commentId).style.display = 'inline';
   }