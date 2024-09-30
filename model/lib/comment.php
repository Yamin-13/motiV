<?php

// Récupère tous les commentaires pour une récompense donnée
function getCommentsByRewardId($idReward, $dbConnection)
{
    // Prépare une requête pour sélectionner les commentaires liés à une récompense spécifique
    $query = "SELECT id, text, date, idUser FROM comment WHERE idReward = :idReward ORDER BY date DESC";
    $statement = $dbConnection->prepare($query);
    // Lie l'ID de la récompense au paramètre de la requête
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);
    // Exécute la requête
    $statement->execute();
    // Retourne tous les commentaires sous forme de tableau associatif
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Ajoute un commentaire
function addComment($idReward, $idUser, $text, $dbConnection)
{
    // Prépare une requête pour insérer un nouveau commentaire dans la base de données
    $query = "INSERT INTO comment (idReward, idUser, text, date) VALUES (:idReward, :idUser, :text, NOW())";
    $statement = $dbConnection->prepare($query);
    // Lie les paramètres aux valeurs fournies
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->bindParam(':text', $text, PDO::PARAM_STR);
    // Exécute la requête pour ajouter le commentaire
    return $statement->execute();
}

// Supprime un commentaire
function deleteComment($idComment, $dbConnection)
{
    // Prépare une requête pour supprimer un commentaire spécifique
    $query = "DELETE FROM comment WHERE id = :idComment";
    $statement = $dbConnection->prepare($query);
    // Lie l'ID du commentaire au paramètre de la requête
    $statement->bindParam(':idComment', $idComment, PDO::PARAM_INT);
    // Exécute la requête pour supprimer le commentaire
    return $statement->execute();
}

// Modifie un commentaire
function updateComment($commentId, $commentText, $dbConnection)
{
    // Prépare une requête pour mettre à jour le texte d'un commentaire
    $query = "UPDATE comment SET text = :commentText, date = NOW() WHERE id = :commentId";
    $statement = $dbConnection->prepare($query);
    // Lie les nouveaux paramètres aux valeurs fournies
    $statement->bindParam(':commentText', $commentText, PDO::PARAM_STR);
    $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    // Exécute la requête pour mettre à jour le commentaire
    return $statement->execute();
}

function getCommentById($idComment, $dbConnection)
{
    // Prépare une requête pour sélectionner un commentaire spécifique
    $query = "SELECT id, text, date, idReward, idUser
              FROM comment 
              WHERE id = :idComment";
    $statement = $dbConnection->prepare($query);
    // Lie l'ID du commentaire au paramètre de la requête
    $statement->bindParam(':idComment', $idComment, PDO::PARAM_INT);
    // Exécute la requête
    $statement->execute();
    // Retourne le commentaire sous forme de tableau associatif
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// Récupère le nom de l'auteur en fonction du rôle (utilisateur ou partenaire)
function getAuthorName($idUser, $dbConnection)
{
    // Sélectionne le rôle, le prénom et le nom de l'utilisateur
    $query = "SELECT idRole, first_name, name FROM user WHERE id = :idUser";
    $statement = $dbConnection->prepare($query);
    // Lie l'ID de l'utilisateur au paramètre de la requête
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    // Exécute la requête
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérifie si l'utilisateur est un partenaire ou une mairie
        if ($user['idRole'] == 30 || $user['idRole'] == 40) { // si c'est un partenaire ou mairie
            // Récupère le nom du partenaire
            $partnerQuery = "SELECT name FROM partner WHERE idUser = :idUser";
            $partnerStatement = $dbConnection->prepare($partnerQuery);
            $partnerStatement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $partnerStatement->execute();
            // Retourne le nom du partenaire
            return $partnerStatement->fetchColumn();
        } else {
            // Sinon, retourne le prénom et le nom de l'utilisateur
            return $user['first_name'] . ' ' . $user['name'];
        }
    }
    // Si l'utilisateur n'existe pas, retourne null
    return null;
}
