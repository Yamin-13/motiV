<?php
function addPartner($name, $email, $siret_number, $address, $idUser, $db)
{
    $query = 'INSERT INTO partner (name, email, siret_number, address, idUser) VALUES (:name, :email, :siret_number, :address, :idUser)';
    $statement = $db->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':siret_number', $siret_number);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':idUser', $idUser);

    return $statement->execute();
}

function getPartnerByUserId($idUser, $db)
{
    $query = 'SELECT name, email, siret_number, address FROM partner WHERE idUser = :idUser';
    $statement = $db->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}
