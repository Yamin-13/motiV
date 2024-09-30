<?php

function addAssociation($name, $description, $phone_number, $address, $idUser, $email, $db)
{
    // Prépare une requête pour ajouter une nouvelle association avec le statut "pending"
    $query = 'INSERT INTO association (name, description, phone_number, address, email, idUser, status) VALUES (:name, :description, :phone_number, :address, :email, :idUser, "pending")';
    $statement = $db->prepare($query);
    // Lie les paramètre aux valeurs fournies
    $statement->bindParam(':name', $name);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':phone_number', $phone_number);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':idUser', $idUser);

    // Exécute la requête pour insérer l'association dans la base de données
    return $statement->execute();
}

function getAssociationByidUser($idUser, $db)
{
    // Récupère l'association associée à un utilisateur spécifique
    $query = 'SELECT a.id, a.name, a.description, a.phone_number, a.address, a.email, a.status, u.name AS president_name, u.first_name AS president_first_name 
              FROM association a
              JOIN user u ON a.idUser = u.id
              WHERE a.idUser = :idUser';
    $statement = $db->prepare($query);
    // Lie l'ID de l'utilisateur au paramètre de la requête
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    // Retourne les informations de l'association sous forme de tableau associatif
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getAssociationById($id, $db)
{
    // Récupère les détails d'une association en fonction de son ID
    $query = 'SELECT id, name, description, phone_number, address, email, status, idUser 
              FROM association 
              WHERE id = :id';
    $statement = $db->prepare($query);
    // Lie l'ID de l'association au paramètre de la requête
    $statement->bindParam(':id', $id);
    $statement->execute();
    // Retourne les informations de l'association
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function updateAssociation($id, $name, $description, $phoneNumber, $address, $email, $dbConnection)
{
    // Met à jour les informations d'une association existante
    $query = "UPDATE association SET name = :name, description = :description, phone_number = :phone_number, address = :address, email = :email WHERE id = :id";
    $statement = $dbConnection->prepare($query);
    // Lie les paramètres aux valeurs fournies
    $statement->bindParam(':id', $id);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':phone_number', $phoneNumber);
    $statement->bindParam(':address', $address);
    $statement->bindParam(':email', $email);
    // Exécute la requête pour mettre à jour l'association
    return $statement->execute();
}

function deleteAssociationById($id, $dbConnection)
{
    // Supprime une association de la base de données en fonction de son ID
    $query = "DELETE FROM association WHERE id = :id";
    $statement = $dbConnection->prepare($query);
    // Lie l'ID de l'association au paramètre de la requête
    $statement->bindParam(':id', $id);
    // Exécute la requête pour supprimer l'association
    return $statement->execute();
}

function getAssociationsWithPresidents($dbConnection)
{
    // Récupère toutes les association avec les information de leur président
    $query = "SELECT a.id, 
                     a.name AS association_name, 
                     u.name AS president_name, 
                     u.first_name AS president_first_name, 
                     u.email AS president_email
              FROM association a
              JOIN user u ON a.idUser = u.id";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    // Retourne la liste des associations avec les présidents
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAssociationByidMember($idUser, $db)
{
    // Récupère l'association à laquelle un membre spécifique appartient
    $query = 'SELECT a.id, a.name, a.description, a.phone_number, a.address, a.email, a.status, u.name AS president_name, u.first_name AS president_first_name
              FROM association a
              JOIN association_user au ON a.id = au.idAssociation
              JOIN user u ON a.idUser = u.id
              WHERE au.idUser = :idUser';
    $statement = $db->prepare($query);
    // Lie l'ID du membre au paramètre de la requête
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    // Retourne les informations de l'association du membre
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getMembersByAssociationId($associationId, $db)
{
    // Récupère tous les membres d'une association spécifique
    $query = 'SELECT u.id, u.name, u.first_name, u.email, au.role
              FROM user u
              JOIN association_user au ON u.id = au.idUser
              WHERE au.idAssociation = :associationId';
    $statement = $db->prepare($query);
    // Lie l'ID de l'association au paramètre de la requête
    $statement->bindParam(':associationId', $associationId);
    $statement->execute();
    // Retourne la liste des membres de l'association
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAssociationIdByUserId($userId, $dbConnection)
{
    // Récupère l'ID de l'association dont l'utilisateur est le président
    $query = "SELECT id FROM association WHERE idUser = :idUser LIMIT 1";
    $statement = $dbConnection->prepare($query);
    // Lie l'ID de l'utilisateur au paramètre de la requête
    $statement->bindParam(':idUser', $userId);
    $statement->execute();
    // Retourne uniquement l'ID de l'association
    return $statement->fetchColumn();
}
