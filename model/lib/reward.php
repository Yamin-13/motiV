<?php

function getAllCategories($dbConnection)
{
    $query = "SELECT id, name FROM category ORDER BY name ASC";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function submitReward($title, $description, $reward_price, $quantity_available, $image_filename, $idUser, $idCategory, $idCityHall = null, $idPartner = null, $dbConnection)
{
    $query = "INSERT INTO reward (title, date, description, reward_price, quantity_available, image_filename, idUser, idCategory, idCityHall, idPartner) 
              VALUES (:title, NOW(), :description, :reward_price, :quantity_available, :image_filename, :idUser, :idCategory, :idCityHall, :idPartner)";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':title', $title);
    $statement->bindParam(':description', $description);
    $statement->bindParam(':reward_price', $reward_price, PDO::PARAM_INT);
    $statement->bindParam(':quantity_available', $quantity_available, PDO::PARAM_INT);
    $statement->bindParam(':image_filename', $image_filename);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->bindParam(':idCategory', $idCategory, PDO::PARAM_INT);

    // Gère les valeur NULL pour idCityHall et idPartner
    if ($idCityHall !== null) {
        $statement->bindParam(':idCityHall', $idCityHall, PDO::PARAM_INT);
    } else {
        $statement->bindValue(':idCityHall', null, PDO::PARAM_NULL);
    }

    if ($idPartner !== null) {
        $statement->bindParam(':idPartner', $idPartner, PDO::PARAM_INT);
    } else {
        $statement->bindValue(':idPartner', null, PDO::PARAM_NULL);
    }

    return $statement->execute();
}

function getAllRewards($dbConnection)
{
    $query = "SELECT id, title, date, description, reward_price, quantity_available, image_filename, idUser, idCategory, idCityHall, idPartner FROM reward ORDER BY date DESC";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getSubmitterName($reward, $dbConnection)
{
    if (!empty($reward['idCityHall'])) {
        $query = "SELECT name FROM city_hall WHERE id = :id";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':id', $reward['idCityHall'], PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchColumn();
    } elseif (!empty($reward['idPartner'])) {
        $query = "SELECT name FROM partner WHERE id = :id";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':id', $reward['idPartner'], PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchColumn();
    } else {
        return 'Submitteur Inconnu';
    }
}

function getRewardById($idReward, $dbConnection)
{
    $query = "SELECT id, title, date, description, reward_price, quantity_available, image_filename, idUser, idCategory, idCityHall, idPartner FROM reward WHERE id = :idReward";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function fetchUserRewardPoints($idUser, $dbConnection)
{
    $query = "SELECT points FROM user WHERE id = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return isset($result['points']) ? intval($result['points']) : 0;
}

function deductUserPoints($idUser, $points, $dbConnection)
{
    $query = "UPDATE user SET points = points - :points WHERE id = :idUser AND points >= :points";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':points', $points, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    return $statement->execute();
}

function insertTransaction($idUser, $idReward, $points, $unique_code, $dbConnection)
{
    $query = "INSERT INTO transaction (transaction_date, number_of_points, idReward, idUser) 
              VALUES (NOW(), :points, :idReward, :idUser)";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':points', $points, PDO::PARAM_INT);
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    return $statement->execute();
}

function updateRewardQuantity($idReward, $dbConnection)
{
    $query = "UPDATE reward SET quantity_available = quantity_available - 1 WHERE id = :idReward AND quantity_available > 0";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);
    return $statement->execute();
}

function generateUniqueCode()
{
    return strtoupper(bin2hex(random_bytes(4))); // Génère un code de 8 caractères hexadécimaux
}

function getCityHallIdByUserId($idUser, $dbConnection)
{
    $query = "SELECT id FROM city_hall WHERE idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['id'] : null;
}

function getPartnerIdByUserId($idUser, $dbConnection)
{
    $query = "SELECT id FROM partner WHERE idUser = :idUser";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['id'] : null;
}