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

function getPartnerByidUser($idUser, $db)
{
    $query = 'SELECT id, name, email, siret_number, address, status FROM partner WHERE idUser = :idUser';
    $statement = $db->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getPartnerById($id, $db)
{
    $query = 'SELECT id, name, email, siret_number, address, status, idUser FROM partner WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getPartnersWithDetails($dbConnection) {
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