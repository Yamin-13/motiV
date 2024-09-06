<?php

function getAllCategories($dbConnection)
{
    $query = "SELECT id, name FROM category ORDER BY name ASC";
    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function submitReward($title, $description, $reward_price, $quantity_available, $image_filename, $idUser, $idCategory, $idCityHall = null, $idPartner = null, $start_date_usage = null, $expiration_date = null, $dbConnection)
{
    $query = "INSERT INTO reward (title, date, description, reward_price, quantity_available, image_filename, idUser, idCategory, idCityHall, idPartner, start_date_usage, expiration_date) 
              VALUES (:title, NOW(), :description, :reward_price, :quantity_available, :image_filename, :idUser, :idCategory, :idCityHall, :idPartner, :start_date_usage, :expiration_date)";

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

    // Gère les date de début et d'expiration
    if ($start_date_usage !== null) {
        $statement->bindParam(':start_date_usage', $start_date_usage);
    } else {
        $statement->bindValue(':start_date_usage', null, PDO::PARAM_NULL);
    }

    if ($expiration_date !== null) {
        $statement->bindParam(':expiration_date', $expiration_date);
    } else {
        $statement->bindValue(':expiration_date', null, PDO::PARAM_NULL);
    }

    return $statement->execute();
}

function getAllRewards($dbConnection)
{
    $query = "SELECT id, title, date, description, reward_price, quantity_available, image_filename, idUser, idCategory, idCityHall, idPartner, expiration_date 
              FROM reward 
              ORDER BY date DESC";

    $statement = $dbConnection->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getSubmitterName($reward, $dbConnection)
{
    if (!empty($reward['idCityHall'])) {
        $query = "SELECT name FROM city_hall WHERE id = :idCityHall";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idCityHall', $reward['idCityHall'], PDO::PARAM_INT);
    } elseif (!empty($reward['idPartner'])) {
        $query = "SELECT name FROM partner WHERE id = :idPartner";
        $statement = $dbConnection->prepare($query);
        $statement->bindParam(':idPartner', $reward['idPartner'], PDO::PARAM_INT);
    } else {
        return 'Submitter inconnu';
    }

    $statement->execute();
    return $statement->fetchColumn();
}

function getRewardById($idReward, $dbConnection)
{
    $query = "SELECT id, title, date, description, reward_price, quantity_available, image_filename, idUser, idCategory, idCityHall, idPartner, start_date_usage, expiration_date
              FROM reward
              WHERE id = :idReward";
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

function insertTransaction($idUser, $idReward, $points, $dbConnection)
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

function insertUniqueCode($code, $idReward, $idUser, $dbConnection)
{
    $query = "INSERT INTO unique_codes (code, idReward, idUser, generated_at, status) 
              VALUES (:code, :idReward, :idUser, NOW(), 'valid')";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':code', $code);
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    return $statement->execute();
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

function deleteReward($idReward, $dbConnection)
{
    $query = "DELETE FROM reward WHERE id = :idReward";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);
    return $statement->execute();
}

function hasUserAlreadyRedeemed($idUser, $idReward, $dbConnection)
{
    $query = "SELECT COUNT(1) FROM transaction WHERE idUser = :idUser AND idReward = :idReward";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->bindParam(':idReward', $idReward, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchColumn() > 0;
}

function getUserPurchaseHistory($idUser, $dbConnection)
{
    $query = "SELECT t.transaction_date, t.number_of_points, uc.code AS unique_code, r.title AS reward_title, r.id AS idReward
              FROM transaction t
              JOIN reward r ON t.idReward = r.id
              LEFT JOIN unique_codes uc ON uc.idReward = r.id AND uc.idUser = t.idUser
              WHERE t.idUser = :idUser
              ORDER BY t.transaction_date DESC";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


function getRewardsHistoryByPartner($idPartner, $dbConnection)
{
    $query = "SELECT r.id, r.title, r.reward_price, r.quantity_available, COUNT(t.id) AS total_exchanges
              FROM reward r
              LEFT JOIN transaction t ON r.id = t.idReward
              WHERE r.idPartner = :idPartner
              GROUP BY r.id";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idPartner', $idPartner);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getRewardsHistoryByCityHall($idCityHall, $dbConnection)
{
    $query = "SELECT r.id, r.title, r.reward_price, r.quantity_available, COUNT(t.id) AS total_exchanges
              FROM reward r
              LEFT JOIN transaction t ON r.id = t.idReward
              WHERE r.idCityHall = :idCityHall
              GROUP BY r.id";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idCityHall', $idCityHall);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupéré les détails de la récompense et du jeune à partir du code unique
function getRewardDetailsByCode($code, $dbConnection)
{
    $query = "SELECT uc.code, uc.idReward, uc.idUser, uc.generated_at, uc.used_at, uc.status, 
                     r.title, r.description, r.reward_price, r.image_filename, u.first_name, u.name
              FROM unique_codes uc
              JOIN reward r ON uc.idReward = r.id
              JOIN user u ON uc.idUser = u.id
              WHERE uc.code = :code AND uc.status = 'valid'";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':code', $code, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// Fonction pour mettre à jour le statut du code unique à 'used'
function updateCodeStatusToUsed($code, $dbConnection)
{
    $query = "UPDATE unique_codes 
              SET status = 'used', used_at = NOW() 
              WHERE code = :code AND status = 'valid'"; // ca met à jour uniquement les code qui sont encore valide
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':code', $code, PDO::PARAM_STR);
    return $statement->execute();
}

function generateQRCodeUrl($uniqueCode)
{
    $baseUrl = "https://api.qrserver.com/v1/create-qr-code/";
    $dataUrl = "http://localhost:49937/ctrl/reward/validate.php?code=" . $uniqueCode; // Construit l'URL complète sans encodage
    $params = [
        'size' => '300x300',
        'data' => $dataUrl // passe l'URL sans l'encoder
    ];
    $queryString = http_build_query($params);
    return "{$baseUrl}?{$queryString}";
}

function getRewardAndUserByCode($code, $dbConnection)
{
    $query = "SELECT r.title, r.description, r.reward_price, u.first_name, u.name 
              FROM unique_codes uc
              JOIN reward r ON uc.idReward = r.id
              JOIN user u ON uc.idUser = u.id
              WHERE uc.code = :code AND uc.status = 'valid'";
    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':code', $code, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getUserCodes($idUser, $dbConnection)
{
    $query = "SELECT uc.code, uc.status, uc.expiration_date AS code_expiration, uc.generated_at, uc.used_at, r.title, r.image_filename, r.start_date_usage, r.expiration_date AS reward_expiration
          FROM unique_codes uc
          JOIN reward r ON uc.idReward = r.id
          WHERE uc.idUser = :idUser
          ORDER BY uc.generated_at DESC";

    $statement = $dbConnection->prepare($query);
    $statement->bindParam(':idUser', $idUser, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
