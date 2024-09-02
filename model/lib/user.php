<?php

// Fonction pour ajouter un utilisateur à la bases de données
function addUser($email, $name, $firstName, $password, $idRole, $fileName, $dateOfBirth, $address, $points, $ine_number, $db)
{
    $query = 'INSERT INTO user ( email, password, name, first_name, idRole, avatar_filename, date_of_birth, address, points, ine_number) VALUES (:email, :password, :name, :first_name, :idRole, :avatar_filename, :date_of_birth, :address, :points, :ine_number)'; // requete SQL avec les parametres pour insérer un nouvel utilisateur dans la table...
    $statement = $db->prepare($query);   // prepare la requete SQL ele retourne un objet PDOstatement                               // ...user avec les 3 collones 
    $statement->bindParam(':email', $email);        // methode PDOStatement::bindParam // 
    $statement->bindParam(':password', $password); //                                 //
    $statement->bindParam(':name', $name);
    $statement->bindParam(':first_name', $firstName); //                                 //
    $statement->bindParam(':idRole', $idRole);       //  <----------------------------- // ca lie la valeeur de $idRole au parametre ":idRole" dans la requête SQL ($idRole = :idRole ) 
    $avatarFilename = basename($fileName); // Assignation à une variable
    $statement->bindParam(':avatar_filename', $avatarFilename, PDO::PARAM_STR);
    $statement->bindParam(':date_of_birth', $dateOfBirth);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':points', $points);
    $statement->bindParam(':ine_number', $ine_number);

    if ($statement->execute()) {
        return $db->lastInsertId();  // Retourne l'ID de l'utilisateur nouvellement inséré
    } else {
        return false;  // Retourne false si l'insertion échoue
    }
}

function getUser(string $email, string $password, PDO $db)
{
    // - Prépare la requête
    $query = 'SELECT user.name, user.email, user.first_name, user.password, user.idRole, user.id, user.registration_date, user.address, user.avatar_filename, user.date_of_birth';
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

function updateUserProfile($idUser, $name, $email, $avatarFilename, $firstName, $password, $idRole, $ineNumber = null, $address = null, $dateOfBirth = null, $dbConnection)
{
    $query = 'UPDATE user SET name = :name, email = :email, avatar_filename = :avatar_filename, first_name = :first_name, password = :password, idRole = :idRole';

    // Ajouter les champs optionnels
    if ($ineNumber !== null) {
        $query .= ', ine_number = :ine_number';
    }
    if ($address !== null) {
        $query .= ', address = :address';
    }
    if ($dateOfBirth !== null) {
        $query .= ', date_of_birth = :date_of_birth';
    }

    // Marque le profil comme complet
    $query .= ', profile_complete = 1';

    $query .= ' WHERE id = :id';

    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':avatar_filename', $avatarFilename);
    $statement->bindParam(':first_name', $firstName);
    $statement->bindParam(':password', $password);
    $statement->bindParam(':idRole', $idRole);
    $statement->bindParam(':id', $idUser);

    if ($ineNumber !== null) {
        $statement->bindParam(':ine_number', $ineNumber);
    }
    if ($address !== null) {
        $statement->bindParam(':address', $address);
    }
    if ($dateOfBirth !== null) {
        $statement->bindParam(':date_of_birth', $dateOfBirth);
    }

    return $statement->execute();
}



// fonction pour récupérer les utilisateurs par rôle
function getUsersByRole($dbConnection)
{
    $query = "SELECT 
            u.id, 
            u.name, 
            u.first_name, 
            u.email,
            u.points, 
            u.idRole,
            r.label AS role
        FROM user u
        JOIN role r ON u.idRole = r.id
        ORDER BY r.label
    ";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getUserById($id, $dbConnection)
{
    $query = " SELECT id, name, first_name, email, ine_number, date_of_birth, address, password, avatar_filename, registration_date, last_connexion, idRole, profile_complete, points
        FROM user
        WHERE id = :id
    ";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function deleteUserById($id, $dbConnection)
{
    $query = "DELETE FROM user WHERE id = :id";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':id', $id);
    return $statement->execute();
}

function getUserByEmail($email, $dbConnection)
{
    $query = 'SELECT id, name, first_name, email, date_of_birth, address, password, avatar_filename, registration_date, last_connexion, idRole 
              FROM user 
              WHERE email = :email';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getUserByIne($ineNumber, $dbConnection)
{
    $query = "SELECT id, name, first_name, email, points FROM user WHERE ine_number = :ine_number";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':ine_number', $ineNumber);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function updateUserPoints($idUser, $points, $dbConnection)
{
    $query = 'UPDATE user SET points = :points WHERE id = :id';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':points', $points);
    $statement->bindParam(':id', $idUser);
    return $statement->execute();
}
