<?php

// Fonction pour ajouter un utilisateur à la bases de données
function addUser($email, $password, $idRole, $db)
{
    $query = 'INSERT INTO user ( email, password, idRole) VALUES (:email, :password, :idRole)'; // requete SQL avec les parametres pour insérer un nouvel utilisateur dans la table...
    $statement = $db->prepare($query);   // prepare la requete SQL ele retourne un objet PDOstatement                               // ...user avec les 3 collones 
    $statement->bindParam(':idRole', $idRole);       //  <----------------------------- // ca lie la valeeur de $idRole au parametre ":idRole" dans la requête SQL ($idRole = :idRole ) 
    $statement->bindParam(':email', $email);        // methode PDOStatement::bindParam // (sécurisé)
    $statement->bindParam(':password', $password); //                                 //

    return $statement->execute();  // PDOStatement::execute (ca execute les requetes et retourne true ou false pour l'insert to) 

}
