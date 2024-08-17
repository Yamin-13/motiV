<?php
function awardPoints($userId, $points, $reason, $dbConnection) {
    // insère un enregistremen dans la table point
    $query = "INSERT INTO point (idUser, number_of_points, reason) VALUES (:idUser, :number_of_points, :reason)";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $userId);
    $statement->bindParam(':number_of_points', $points);
    $statement->bindParam(':reason', $reason);
    $statement->execute();

    // Met à jour les point de l'utilisateur dans la table user
    $query = "UPDATE user SET points = points + :points WHERE id = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':points', $points);
    $statement->bindParam(':idUser', $userId);
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
