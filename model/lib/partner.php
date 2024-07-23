<?php
function addPartner($name, $siret_number, $address, $idUser, $db)
{
    $query = 'INSERT INTO partner (name, siret_number, address, idUser) VALUES (:name, :siret_number, :address, :idUser)';
    $statement = $db->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':siret_number', $siret_number);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':idUser', $idUser);

    return $statement->execute();
}

