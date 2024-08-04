<?php

function getUserByEmail($email, $db) {
    $query = 'SELECT * FROM user WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function savePasswordResetToken($email, $token, $expiry, $db) {
    $query = 'INSERT INTO password_resets (email, token, expiry) VALUES (:email, :token, :expiry)';
    $statement = $db->prepare($query);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':token', $token);
    $statement->bindParam(':expiry', $expiry);
    $statement->execute();
}

function getPasswordResetRequest($token, $db) {
    $query = 'SELECT * FROM password_resets WHERE token = :token';
    $statement = $db->prepare($query);
    $statement->bindParam(':token', $token);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function updateUserPassword($email, $password, $db) {
    $query = 'UPDATE user SET password = :password WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindParam(':password', $password);
    $statement->bindParam(':email', $email);
    $statement->execute();
}

function deletePasswordResetToken($token, $db) {
    $query = 'DELETE FROM password_resets WHERE token = :token';
    $statement = $db->prepare($query);
    $statement->bindParam(':token', $token);
    $statement->execute();
}