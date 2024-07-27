<?php
function addAssociation($name, $description, $phone_number, $address, $idUser, $email, $db)
{
    $query = 'INSERT INTO association (name, description, phone_number, address, email, idUser) VALUES (:name, :description, :phone_number, :address, :email, :idUser)';
    $statement = $db->prepare($query);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':phone_number', $phone_number);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':idUser', $idUser);

    return $statement->execute();
}

function getAssociationByUserId($idUser, $db)
{
    $query = 'SELECT name, description, phone_number, address, email, idUser 
    FROM association 
    WHERE idUser = :idUser';
    $statement = $db->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}
