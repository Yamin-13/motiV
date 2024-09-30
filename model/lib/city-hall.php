<?php

function addCityHall($name, $email, $phoneNumber, $address, $idUser, $dbConnection)
{
    // Prépare une requête pour ajouter une nouvelle mairie dans la base de données
    $query = 'INSERT INTO city_hall (name, email, phone_number, address, idUser) VALUES (:name, :email, :phone_number, :address, :idUser)';
    $statement = $dbConnection->prepare($query);
    // Lie les paramètres aux valeurs fournies
    $statement->bindParam(':name', $name);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':idUser', $idUser);

    // Exécute la requête pour insérer la mairie dans la base de données
    return $statement->execute();
}

function getCityHallByIdUser($idUser, $dbConnection)
{
    // Récupère les informations de la mairie associée à un utilisateur spécifique
    $query = 'SELECT id, name, email, phone_number, address, image_filename, idUser 
              FROM city_hall 
              WHERE idUser = :idUser';
    $statement = $dbConnection->prepare($query);
    // Lie l'ID de l'utilisateur au paramètre de la requête
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    // Retourne les informations de la mairie sous forme de tableau associatif
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getMembersByCityHallId($cityHallId, $dbConnection)
{
    // Récupère tous les membres associés à une mairie spécifique
    $query = 'SELECT u.id, u.first_name, u.name, u.email 
              FROM user u 
              JOIN city_hall_user chu ON u.id = chu.idUser 
              WHERE chu.idCityHall = :idCityHall';
    $statement = $dbConnection->prepare($query);
    // Lie l'ID de la mairie au paramètre de la requête
    $statement->bindParam(':idCityHall', $cityHallId);
    $statement->execute();
    // Retourne la liste des membres de la mairie
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function updateCityHall($id, $name, $phoneNumber, $address, $email, $imageFilename, $dbConnection)
{
    // Met à jour les informations d'une mairie existante
    $query = 'UPDATE city_hall 
              SET name = :name, phone_number = :phone_number, address = :address, email = :email, image_filename = :image_filename
              WHERE id = :id';
    $statement = $dbConnection->prepare($query);
    // Lie les nouvelles valeurs aux paramètres de la requête
    $statement->bindParam(':name', $name);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':image_filename', $imageFilename);
    $statement->bindParam(':id', $id);

    // Exécute la requête pour mettre à jour la mairie dans la base de données
    return $statement->execute();
}

function getCityHallById($id, $dbConnection)
{
    // Récupère les détails d'une mairie en fonction de son ID
    $query = 'SELECT id, name, email, phone_number, address, image_filename, idUser 
              FROM city_hall 
              WHERE id = :id';
    $statement = $dbConnection->prepare($query);
    // Lie l'ID de la mairie au paramètre de la requête
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    // Retourne les informations de la mairie
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getCityHallByIdMember($userId, $dbConnection)
{
    // Récupère la mairie associée à un membre spécifique
    $query = 'SELECT ch.id, ch.name, ch.email, ch.phone_number, ch.address, ch.image_filename, ch.idUser 
              FROM city_hall_user chu
              JOIN city_hall ch ON chu.idCityHall = ch.id
              WHERE chu.idUser = :userId';
    $statement = $dbConnection->prepare($query);
    // Lie l'ID du membre au paramètre de la requête
    $statement->bindParam(':userId', $userId);
    $statement->execute();
    // Retourne les informations de la mairie du membre
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getCityHallsWithAdmins($dbConnection)
{
    // Récupère toutes les mairies avec les informations de leurs administrateurs
    $query = "SELECT ch.id, ch.name AS city_hall_name, u.name AS admin_name, u.first_name AS admin_first_name, u.email AS admin_email
              FROM city_hall ch
              JOIN user u ON ch.idUser = u.id";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    // Retourne la liste des mairies avec leurs administrateurs
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getCityHallsWithDetails($dbConnection)
{
    // Récupère toutes les mairies avec des détails supplémentaires
    $query = "SELECT 
                ch.id, 
                ch.name AS city_hall_name, 
                u.name AS admin_name, 
                u.first_name AS admin_first_name, 
                u.email AS admin_email,
                ch.phone_number AS city_hall_phone_number
              FROM city_hall ch
              JOIN user u ON ch.idUser = u.id";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    // Retourne la liste des mairies avec les détails supplémentaires
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
