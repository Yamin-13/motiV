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

function getUser(string $email, string $password, PDO $db)
{
    // - Prépare la requête
    $query = 'SELECT user.email, user.password';
    $query .= ' FROM user';
    $query .= ' WHERE user.email = :email ';
    $statement = $db->prepare($query);
    $statement->bindParam(':email', $email);

    // - Exécute la requête
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // conditions pour verifier le password hashé correspond. "password_verify" retourne true ou false si le mot de passe fourni correspond au haché stocké
    if ($user && password_verify($password, $user['password'])) {  // $password c'st le mot de passe en clair fournis, $user['password'] c'est le mot de passe haché de la BDD

        // Si les deux conditions sont vraies (l'utilisateur existe et le mot de passe est correct)...
        // ... alors la fonction retourne les données de l'utilisateur 
        return $user;
    } else {
        // Ca retourne null si les conditios sont false
        return null;
    }
}