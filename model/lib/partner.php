<?php

function addPartner($name, $email, $siret, $address, $idUser, $status, $db)
{
    $query = 'INSERT INTO partner (name, email, siret_number, address, idUser, status) VALUES (:name, :email, :siret, :address, :idUser, :status)';
    $statement = $db->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':siret', $siret);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':idUser', $idUser);
    $statement->bindParam(':status', $status);

    return $statement->execute();
}

function updatePartner($id, $name, $siretNumber, $address, $email, $dbConnection)
{
    $query = "UPDATE partner SET name = :name, siret_number = :siret_number, address = :address, email = :email WHERE id = :id";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':siret_number', $siretNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    return $statement->execute();
}

function getPartnerByidUser($idUser, $db)
{
    $query = 'SELECT p.id, p.name, p.email, p.siret_number, p.address, p.status, u.name AS president_name, u.first_name AS president_first_name
              FROM partner p
              JOIN user u ON p.idUser = u.id
              WHERE p.idUser = :idUser';
    $statement = $db->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getPartnerById($id, $db)
{
    $query = 'SELECT id, name, email, siret_number, address, status, idUser 
    FROM partner 
    WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function deletePartnerById($id, $dbConnection)
{
    $query = "DELETE FROM partner WHERE id = :id";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':id', $id);
    return $statement->execute();
}

function getPartnersWithDetails($dbConnection)
{
    $query = "
        SELECT 
            p.id, 
            p.name AS partner_name, 
            u.name AS partner_full_name, 
            u.first_name AS partner_first_name, 
            u.email AS partner_email
        FROM partner p
        JOIN user u ON p.idUser = u.id
    ";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getMembersByPartnerId($partnerId, $db)
{
    $query = 'SELECT u.id, u.name, u.first_name, u.email
              FROM user u
              JOIN partner_user pu ON u.id = pu.idUser
              WHERE pu.idPartner = :partnerId';
    $statement = $db->prepare($query);
    $statement->bindParam(':partnerId', $partnerId);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getPartnerByidMember($idUser, $db)
{
    $query = 'SELECT p.id, p.name, p.email, p.siret_number, p.address, p.status, u.name AS president_name, u.first_name AS president_first_name
              FROM partner p
              JOIN partner_user pu ON p.id = pu.idPartner
              JOIN user u ON p.idUser = u.id
              WHERE pu.idUser = :idUser';
    $statement = $db->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}
