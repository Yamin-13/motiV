<?php

function createInvitation($email, $token, $expiry, $associationId, $partnerId, $entityType, $idRole, $dbConnection) {
    $query = 'INSERT INTO invitation (email, token, expiry, idAssociation, idPartner, entity_type, idRole) VALUES (:email, :token, :expiry, :idAssociation, :idPartner, :entityType, :idRole)';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':token', $token);
    $statement->bindParam(':expiry', $expiry);
    $statement->bindParam(':idAssociation', $associationId);
    $statement->bindParam(':idPartner', $partnerId);
    $statement->bindParam(':entityType', $entityType);
    $statement->bindParam(':idRole', $idRole);

    return $statement->execute();
}

function getInvitationByToken($token, $dbConnection) {
    $query = 'SELECT id, email, token, expiry, idAssociation, idPartner, entity_type, idRole 
    FROM invitation 
    WHERE token = :token';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':token', $token);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function deleteInvitation($id, $dbConnection) {
    $query = 'DELETE FROM invitation WHERE id = :id';
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':id', $id);
    return $statement->execute();
}
