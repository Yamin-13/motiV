<?php

// Récupère tous les commentaire pour une récompense donnée
function getCommentsByRewardId($idReward, $dbConnection)
{
    $query = "SELECT id, text, date, idUser FROM comment WHERE idReward = :idReward ORDER BY date DESC";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Ajoute un commentaire
function addComment($idReward, $idUser, $text, $dbConnection)
{
    $query = "INSERT INTO comment (idReward, idUser, text, date) VALUES (:idReward, :idUser, :text, NOW())";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->bindParam(':text', $text, PDO::PARAM_STR);
    return $statement->execute();
}

// Supprime un commentaire
function deleteComment($idComment, $dbConnection)
{
    $query = "DELETE FROM comment WHERE id = :idComment";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idComment', $idComment, PDO::PARAM_INT);
    return $statement->execute();
}

// Modifie un commentaire
function updateComment($commentId, $commentText, $dbConnection)
{
    $query = "UPDATE comment SET text = :commentText, date = NOW() WHERE id = :commentId";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':commentText', $commentText, PDO::PARAM_STR);
    $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    return $statement->execute();
}

function getCommentById($idComment, $dbConnection)
{
    $query = "SELECT * FROM comment WHERE id = :idComment";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idComment', $idComment, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// Récupère le nom de l'auteur en fonction du rôle (utilisateur ou partenaire)
function getAuthorName($idUser, $dbConnection)
{
    $query = "SELECT idRole, first_name, name FROM user WHERE id = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['idRole'] == 30 || $user['idRole'] == 40) { // Si c'est un partenaire ou mairie
            // récupère le nom du partenaire
            $partnerQuery = "SELECT name FROM partner WHERE idUser = :idUser";
            $partnerStatement = $dbConnection->prepare($partnerQuery);
            $partnerStatement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $partnerStatement->execute();
            return $partnerStatement->fetchColumn();
        } else {
            // sinon retourne le prénom nom de l'utilisateur
            return $user['first_name'] . ' ' . $user['name'];
        }
    }
    return null;
}
