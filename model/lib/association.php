<?php

/**
 * Ajoute une nouvelle association dans la base de données avec un statut "pending".
 * 
 * @param string $name Le nom de l'association
 * @param string $description La description de l'association
 * @param string $phone_number Le numéro de téléphone de l'association
 * @param string $address L'adresse de l'association
 * @param string $idUser L'ID de l'utilisateur créant l'association
 * @param string $email L'email de l'association
 * @param \PDO $db Connexion à la base de données
 * @return bool Retourne true si l'insertion est réussie, sinon false
 */
function addAssociation(
    string $name,
    string $description,
    string $phone_number,
    string $address,
    string $idUser,
    string $email,
    \PDO $db
): bool {
    // Prépare une requête pour ajouter une nouvelle association avec le statut "pending"
    $query = 'INSERT INTO association (name, description, phone_number, address, email, idUser, status) 
              VALUES (:name, :description, :phone_number, :address, :email, :idUser, "pending")';

    $statement = $db->prepare($query);

    // Lier les paramètres aux valeurs fournies
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
    $statement->bindParam(':address', $address, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);

    // Exécute la requête pour insérer l'association dans la base de données
    return $statement->execute();
}

/**
 * Récupère les informations d'une association liée à un utilisateur spécifique.
 * 
 * @param int $idUser L'ID de l'utilisateur
 * @param \PDO $db Connexion à la base de données
 * @return array|false Retourne un tableau associatif contenant les informations de l'association si trouvé sinon false
 */
function getAssociationByidUser(int $idUser, \PDO $db)
{
    // Prépare une requête pour récupérer l'association associée à un utilisateur spécifique
    $query = 'SELECT a.id, a.name, a.description, a.phone_number, a.address, a.email, a.status, 
                     u.name AS president_name, u.first_name AS president_first_name 
              FROM association a
              JOIN user u ON a.idUser = u.id
              WHERE a.idUser = :idUser';

    $statement = $db->prepare($query);

    // Lie l'ID de l'utilisateur au paramètre de la requête
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();

    // Retourne les informations de l'association sous forme de tableau associatif
    return $statement->fetch(PDO::FETCH_ASSOC);
}


/**
 * Récupère les détails d'une association en fonction de son ID.
 * 
 * @param int $id L'ID de l'association
 * @param \PDO $db Connexion à la base de données
 * @return array|false Retourne un tableau associatif...
 *                      ...contenant les informations de l'association si trouvé sinon false
 */
function getAssociationById(int $id, \PDO $db)
{
    // Prépare une requête pour récupérer les détails d'une association en fonction de son ID
    $query = 'SELECT id, name, description, phone_number, address, email, status, idUser 
              FROM association 
              WHERE id = :id';

    $statement = $db->prepare($query);

    // Lie l'ID de l'association au paramètre de la requête
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    // Retourne les informations de l'association sous forme de tableau associatif
    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Met à jour les informations d'une association existante.
 * 
 * @param int $id L'ID de l'association à mettre à jour
 * @param string $name Le nom de l'association
 * @param string $description La description de l'association
 * @param string $phoneNumber Le numéro de téléphone de l'association
 * @param string $address L'adresse de l'association
 * @param string $email L'email de l'association
 * @param \PDO $dbConnection Connexion à la base de données
 * @return bool Retourne true si la mise à jour a réussi, sinon false
 */
function updateAssociation(int $id, 
         string $name, 
         string $description, 
         string $phoneNumber, 
         string $address, 
         string $email, 
         \PDO $dbConnection
         ): bool{
    // Prépare la requête pour mettre à jour les informations de l'association
    $query = "UPDATE association 
              SET name = :name, description = :description, phone_number = :phone_number, 
                  address = :address, email = :email 
              WHERE id = :id";
    
    $statement = $dbConnection->prepare($query);

    // Lie les paramètres aux valeurs fournies
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
    $statement->bindParam(':address', $address, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);

    // Exécute la requête pour mettre à jour l'association
    return $statement->execute();
}


/**
 * Supprime une association de la base de données en fonction de son ID.
 * 
 * @param int $id L'ID de l'association à supprimer
 * @param \PDO $dbConnection Connexion à la base de données
 * @return bool Retourne true si la suppression a réussi, sinon false
 */
function deleteAssociationById(int $id, \PDO $dbConnection): bool
{
    // Prépare la requête pour supprimer l'association de la base de données
    $query = "DELETE FROM association WHERE id = :id";
    
    $statement = $dbConnection->prepare($query);

    // Lie l'ID de l'association au paramètre de la requête
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

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
