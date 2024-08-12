<?php

function addEducationalEstablishment($name, $email, $phoneNumber, $address, $NIE_number, $idUser, $dbConnection)
{
    $query = 'INSERT INTO educational_establishment (name, email, phone_number, address, NIE_number, idUser) 
              VALUES (:name, :email, :phone_number, :address, :NIE_number, :idUser)';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':NIE_number', $NIE_number);
    $statement->bindParam(':idUser', $idUser);

    return $statement->execute();
}

function getEducationalEstablishmentByIdUser($idUser, $dbConnection)
{
    $query = 'SELECT ee.id, ee.name, ee.email, ee.phone_number, ee.address, ee.NIE_number, u.name AS admin_name, u.first_name AS admin_first_name 
              FROM educational_establishment ee
              JOIN user u ON ee.idUser = u.id
              WHERE ee.idUser = :idUser';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getMembersByEducationalId($educationalId, $dbConnection)
{
    $query = 'SELECT u.id, u.first_name, u.name, u.email 
              FROM user u 
              JOIN educational_establishment_user eeu ON u.id = eeu.idUser 
              WHERE eeu.idEducationalEstablishment = :idEducational';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idEducational', $educationalId);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function updateEducationalEstablishment($id, $name, $phoneNumber, $address, $email, $NIE_number, $dbConnection)
{
    $query = 'UPDATE educational_establishment 
              SET name = :name, phone_number = :phone_number, address = :address, email = :email, NIE_number = :NIE_number
              WHERE id = :id';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':NIE_number', $NIE_number);
    $statement->bindParam(':id', $id);

    return $statement->execute();
}

function getEducationalEstablishmentById($id, $dbConnection)
{
    $query = 'SELECT id, name, email, phone_number, address, NIE_number, idUser 
              FROM educational_establishment 
              WHERE id = :id';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getEducationalEstablishmentByIdMember($idUser, $dbConnection)
{
    $query = 'SELECT ee.id, ee.name, ee.email, ee.phone_number, ee.address, ee.NIE_number, u.name AS admin_name, u.first_name AS admin_first_name
              FROM educational_establishment ee
              JOIN educational_establishment_user eeu ON ee.id = eeu.idEducationalEstablishment
              JOIN user u ON ee.idUser = u.id
              WHERE eeu.idUser = :idUser';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getEducationalEstablishmentsWithAdmins($dbConnection)
{
    $query = "
        SELECT ee.id, ee.name AS establishment_name, u.name AS admin_name, u.first_name AS admin_first_name, u.email AS admin_email
        FROM educational_establishment ee
        JOIN user u ON ee.idUser = u.id
    ";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getEducationalEstablishmentsWithDetails($dbConnection)
{
    $query = "
        SELECT 
            ee.id, 
            ee.name AS establishment_name, 
            u.name AS admin_name, 
            u.first_name AS admin_first_name, 
            u.email AS admin_email,
            ee.phone_number AS establishment_phone_number
        FROM educational_establishment ee
        JOIN user u ON ee.idUser = u.id
    ";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}