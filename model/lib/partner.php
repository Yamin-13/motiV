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
