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
    $query = 'SELECT id, name, description, phone_number, address, email, status FROM association WHERE idUser = :idUser';
    $statement = $db->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getAssociationById($id, $db)
{
    $query = 'SELECT id, name, description, phone_number, address, email, status, idUser FROM association WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindParam(':id', $id);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
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
