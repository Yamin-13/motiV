<?php
function awardPoints($userId, $points, $reason, $dbConnection) {
    // Vérifie les points actuels de l'utilisateur
    $currentPoints = getUserPoints($userId, $dbConnection);

    // Calcul des nouveaux points
    $newPoints = max(0, $currentPoints + $points); // ca empeche les point de devenir négatifs

    // Met à jour les points de l'utilisateur
    $query = "UPDATE user SET points = :points WHERE id = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':points', $newPoints);
    $statement->bindParam(':idUser', $userId);
    $statement->execute();

    // Enregistre la transaction dans la table point
    $query = "INSERT INTO point (idUser, number_of_points, reason) VALUES (:idUser, :number_of_points, :reason)";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $userId);
    $statement->bindParam(':number_of_points', $points);
    $statement->bindParam(':reason', $reason);
    $statement->execute();
}

// Récupere les logs des points
function getPointLogs($userId, $dbConnection) {
    $query = "SELECT number_of_points, reason, date_of_grant FROM point WHERE idUser = :idUser ORDER BY date_of_grant DESC";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $userId);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getUserPoints($userId, $dbConnection) {
    $query = "SELECT points FROM user WHERE id = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $userId);
    $statement->execute();
    return $statement->fetchColumn();
}
