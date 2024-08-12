<?php
function addCityHall($name, $email, $phoneNumber, $address, $idUser, $dbConnection)
{
    $query = 'INSERT INTO city_hall (name, email, phone_number, address, idUser) VALUES (:name, :email, :phone_number, :address, :idUser)';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':idUser', $idUser);

    return $statement->execute();
}

function getCityHallByIdUser($idUser, $dbConnection)
{
    $query = 'SELECT id, name, email, phone_number, address, image_filename, idUser 
              FROM city_hall 
              WHERE idUser = :idUser';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getMembersByCityHallId($cityHallId, $dbConnection)
{
    $query = 'SELECT u.id, u.first_name, u.name, u.email 
              FROM user u 
              JOIN city_hall_user chu ON u.id = chu.idUser 
              WHERE chu.idCityHall = :idCityHall';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idCityHall', $cityHallId);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function updateCityHall($id, $name, $phoneNumber, $address, $email, $imageFilename, $dbConnection)
{
    $query = 'UPDATE city_hall 
              SET name = :name, phone_number = :phone_number, address = :address, email = :email, image_filename = :image_filename
              WHERE id = :id';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':image_filename', $imageFilename);
    $statement->bindParam(':id', $id);

    return $statement->execute();
}

function getCityHallById($id, $dbConnection)
{
    $query = 'SELECT id, name, email, phone_number, address, image_filename, idUser 
              FROM city_hall 
              WHERE id = :id';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getCityHallByIdMember($userId, $dbConnection)
{
    $query = 'SELECT ch.id, ch.name, ch.email, ch.phone_number, ch.address, ch.image_filename, ch.idUser 
              FROM city_hall_user chu
              JOIN city_hall ch ON chu.idCityHall = ch.id
              WHERE chu.idUser = :userId';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':userId', $userId);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getCityHallsWithAdmins($dbConnection)
{
    $query = "
        SELECT ch.id, ch.name AS city_hall_name, u.name AS admin_name, u.first_name AS admin_first_name, u.email AS admin_email
        FROM city_hall ch
        JOIN user u ON ch.idUser = u.id
    ";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getCityHallsWithDetails($dbConnection)
{
    $query = "
        SELECT 
            ch.id, 
            ch.name AS city_hall_name, 
            u.name AS admin_name, 
            u.first_name AS admin_first_name, 
            u.email AS admin_email,
            ch.phone_number AS city_hall_phone_number
        FROM city_hall ch
        JOIN user u ON ch.idUser = u.id
    ";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}