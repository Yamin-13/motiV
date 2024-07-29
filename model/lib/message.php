<?php

function sendMessage($userId, $subject, $body, $dbConnection)
{
    $query = "
        INSERT INTO message (idUser, subject, body) 
        VALUES (:idUser, :subject, :body)
    ";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $userId);
    $statement->bindParam(':subject', $subject);
    $statement->bindParam(':body', $body);

    return $statement->execute();
}

function getMessagesByidUser($idUser, $dbConnection)
{
    $query = "SELECT subject, body, sent_at FROM message WHERE idUser = :idUser ORDER BY sent_at DESC";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
