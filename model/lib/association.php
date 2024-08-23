<?php

function addAssociation($name, $description, $phone_number, $address, $idUser, $email, $db)
{
    $query = 'INSERT INTO association (name, description, phone_number, address, email, idUser, status) VALUES (:name, :description, :phone_number, :address, :email, :idUser, "pending")';
    $statement = $db->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':phone_number', $phone_number);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':idUser', $idUser);

    return $statement->execute();
}

function getAssociationByidUser($idUser, $db)
{
    $query = 'SELECT a.id, a.name, a.description, a.phone_number, a.address, a.email, a.status, u.name AS president_name, u.first_name AS president_first_name 
              FROM association a
              JOIN user u ON a.idUser = u.id
              WHERE a.idUser = :idUser';
    $statement = $db->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getAssociationById($id, $db)
{
    $query = 'SELECT id, name, description, phone_number, address, email, status, idUser 
    FROM association 
    WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function updateAssociation($id, $name, $description, $phoneNumber, $address, $email, $dbConnection)
{
    $query = "UPDATE association SET name = :name, description = :description, phone_number = :phone_number, address = :address, email = :email WHERE id = :id";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    return $statement->execute();
}

function deleteAssociationById($id, $dbConnection)
{
    $query = "DELETE FROM association WHERE id = :id";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':id', $id);
    return $statement->execute();
}

function getAssociationsWithPresidents($dbConnection)
{
    $query = "
    SELECT 
        a.id, 
        a.name AS association_name, 
        u.name AS president_name, 
        u.first_name AS president_first_name, 
        u.email AS president_email
    FROM association a
    JOIN user u ON a.idUser = u.id
";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAssociationByidMember($idUser, $db)
{
    $query = 'SELECT a.id, a.name, a.description, a.phone_number, a.address, a.email, a.status, u.name AS president_name, u.first_name AS president_first_name
              FROM association a
              JOIN association_user au ON a.id = au.idAssociation
              JOIN user u ON a.idUser = u.id
              WHERE au.idUser = :idUser';
    $statement = $db->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getMembersByAssociationId($associationId, $db)
{
    $query = 'SELECT u.id, u.name, u.first_name, u.email, au.role
              FROM user u
              JOIN association_user au ON u.id = au.idUser
              WHERE au.idAssociation = :associationId';
    $statement = $db->prepare($query);
    $statement->bindParam(':associationId', $associationId);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAssociationIdByUserId($userId, $dbConnection) {
    $query = "SELECT id FROM association WHERE idUser = :idUser LIMIT 1";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $userId);
    $statement->execute();
    return $statement->fetchColumn();  //  ca retourne uniquement l'idAssociation
}
